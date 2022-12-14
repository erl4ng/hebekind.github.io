/*

Kontackt Messenger.

email: movileanuion@gmail.com 
fb: fb.com/vaneayoung

Copyright 2020 by Vanea Young


*/



function vy_webrtc_calls(){
	

	
	if(typeof __j == 'undefined'){
		var __j = function(a){return $(a);};
	}
	
    $.fn.extend({
        center: function () {
            return this.each(function() {
                var top = ($(window).height() - $(this).outerHeight()) / 2;
                var left = ($(window).width() - $(this).outerWidth()) / 2;
                $(this).css({position:'absolute', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});
            });
        }
    }); 
	
	
	var self = this;
	self.peer_uniq_id = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
	self.ajax_url = V_HOST+'/messenger.php';
	self.curr_peer_id;
	self.last_peer_id = 0;
	self.reconnectPeerTimeout;
	self.reconnectPeerTimesCount = 20;
	self.peerJS_reconnect_times = 0;
	self.peer;
	self.call;
	self.localStream;
	self.socket = sio;
	self.recipientid;
	self.media_type;
	self.body = __j('body');
	self.close_button;
	self.hangup_button;
	self.answer_button;
	self.call_window;
	self.recipient_media_element;
	self.user_media_element;
	self.peer_conn;
	self.status;
	self.timer;
	self.total_time = !1;
	self.call_initiated = !1;
	self.ms__contacting_sound;
	self.ms__ringing_sound;
	self.ms__incomming_call;
	self.ms___test_sound;
	self.timer_interval;
	self.header_status;
	self.socket_notif_created;
	self.callerid = 0;
	self.mob_last_window_focus =  new Date().getTime();
	self.smartphone_focus_timeout;
	self.ios_simulated = "no";
	self.call_1_ended;
	self.ringing_timeout;
	self.close_call_click_timeout;
	self.last_message_send;
	self.busy_status_timeout;
	self._call_start_timeout;
	self.playing_music_plugin;
	self.media_elements;
	self.call_start_now;
	self.microphone_camera_err_msg = "<br/>Please make sure your microphone and camera are enabled.";
	self.setTime = function(){};
	
	
	// stop music 
	this.stop_music_plugin = function(){
		
		if($.socplusMusic) {
			
			 
			 if($.socplusMusic('is_playing')){
				 
				 $.socplusMusic('pause_playing');
				 self.playing_music_plugin = 1;
			 }
		}
	},
	// play music 
	this.play_music_plugin = function(){
		
		if($.socplusMusic && self.playing_music_plugin) {
			
			$.socplusMusic('continue_playing');
			self.playing_music_plugin = !1;
			
		}
	},
	this.makeCall = function(e,type,id){
		  if(e) evstop(e,1);
		  
			clearTimeout(self._call_start_timeout);
 
			if (!self.call_start_now) {
 
				 self.start_call(type, id);
				 self.call_start_now = 1;

			}

			self._call_start_timeout = setTimeout(function() {
				self.call_start_now = !1;
			}, 2000);
 
 
		  
	},
	this.call_popup = function(media_type,recipient_id){
		
		self.media_type = media_type;
		self.recipientid = recipient_id;
		self.callerid = _U.i;
		self.total_time;
		self.call_1_ended = !1;
		self.ringing_timeout = !1;
		self.call_initiated = 1;
		self.create_sounds(function(){
			self._call_popup();
		});
		
		
		self.stop_music_plugin();

	},
	this.answer_popup = function(call){
 
		
		self.media_type = call.metadata.call_type;
		self.recipientid = call.metadata.user_id;
		self.callerid = call.metadata.user_id;
		self.total_time;
		self.call_1_ended = !1;
		self.ringing_timeout = !1;
		self.call_initiated = 1;
		//self.peer_conn = self.peer.connect(call.metadata.peer_id);
	 
		self.call = call;
		
		self.create_sounds(function(){
			
			self._answer_popup(call);
			
		});
		
		self.stop_music_plugin();
		
		

	},
	this._answer_popup = function(call){
 
		
		if(!self.body.find('#vy_call_popup').length){
			 
			
			const send = jAjax(self.ajax_url,'post',{'cmd':'answer-popup','metadata':JSON.stringify(call.metadata)});
			
			send.done(function(html){
				
				self.call_window = __j(html);
				
				var $html = self.call_window;
				
				self.body.prepend($html);
				self.status = $html.find('#vy_calling_status');
				self.header_status = $html.find('#vy_ms__header_status');
				self.close_button = $html.find('#vy_ms__close_buttonevent');
				self.hangup_button = $html.find('#vy_ms__decline_buttonevent');
				self.answer_button = $html.find('#vy_ms__answer_buttonevent');
				self.media_elements = $html.find('#vy_ms_wbrtc_mediaelement');
 
				// Play sound
				self.play_sound('incoming');

				// send notification that the user is connected
				self.socket.emit("call_user_connected", socketId(call.metadata.user_id));
				self.get_notifications(call.metadata);
				
				self.addEventsToPopup($html);
				
			});
			

		} else {
			

			self.focusCallWindow();			 
			
		}
			
		
	},
	this._call_popup = function(){
 
		
		if(!self.body.find('#vy_call_popup').length){
			
			
			const send = jAjax(self.ajax_url,'post',{'cmd':'call-popup','recipient':escape(self.recipientid),'media_type':self.media_type});
			
			send.done(function(html){
				
				self.call_window = __j(html);
				
				var  $html = self.call_window;
				
				self.body.prepend($html);
				self.status = $html.find('#vy_calling_status');
				self.header_status = $html.find('#vy_ms__header_status');
				self.close_button = $html.find('#vy_ms__close_buttonevent');
				self.hangup_button = $html.find('#vy_ms__decline_buttonevent');
				self.answer_button = $html.find('#vy_ms__answer_buttonevent');
				self.media_elements = $html.find('#vy_ms_wbrtc_mediaelement');
				
				self.addEventsToPopup($html);

				self.initiateCall(self.media_type,self.recipientid,self.localStream);
				
			});
			
			
		} else {
			

			self.focusCallWindow();			 
			
		}
			
		
	},

	this.addEventsToPopup = function($html){
		
				 
				
				// half minimize button
				$html.find('#vy_call_halfmin_btn').off('click.halfminimizeMessCallWindow').on('click.halfminimizeMessCallWindow',function(e){
					
					evstop(e);
 
						$html.addClass('likeclose');
	 
						self.enableDrag($html);
						self.enableResize($html);
					
				});
				
				// half maximize button
				$html.find('#vy_call_halfmaximize_btn').off('click.halfmaximizeMessCallWindow').on('click.halfmaximizeMessCallWindow',function(e){
					
					evstop(e);
					
						$html.removeClass('likeclose').find('div:first').removeAttr('style');
 
						self.disableDrag($html);
						self.disableResize($html);
 
					
				}); 
				
				// minimize 
				$html.find('#vy_call_min_btn').off('click.minimizeMessengerCallWindow').on('click.minimizeMessengerCallWindow',function(e){
					
					evstop(e);
	 
						
						$html.addClass('likeclose minimized');
						
						if(is_smartphone())
							$html.find('#vy_call_js_draggable').removeAttr('style').center();
						else
							$html.find('#vy_call_js_draggable').removeAttr('style').css({'right':'15px','bottom':'15px'});
						
						self.enableDrag($html);
						self.disableResize($html);
 
					
				});
				
				// maximize 
				$html.find('#vy_call_maximize_btn').off('click.maximizeMessengerCallWindow').on('click.maximizeMessengerCallWindow',function(e){
					
					evstop(e);
					 if(is_smartphone()){
						 
						$html.removeClass('likeclose minimized');
						$html.find('#vy_call_js_draggable').center();
						 
						 
					 } else{
						$html.removeClass('minimized');
						$html.find('#vy_call_js_draggable').center();
						self.enableResize($html);
					 }

					
				});
				
				// answer call
				$html.find('#vy_ms__answer_buttonevent').off('click.vy_ms__ANSWER_EVENT').on('click.vy_ms__ANSWER_EVENT',function(e){
					evstop(e,1);
					self.answerThisCall($html);
					// remove answer button
					this.remove();
				});
				
				// end call
				$html.find('#vy_ms__decline_buttonevent').off('click.vy_ms__ENDCALL_EVENT').on('click.vy_ms__ENDCALL_EVENT',function(e){
					evstop(e,1);
					self.destroyThisCall(this,$html);
					
				});
				
				// close button
				$html.find('#vy_ms__close_buttonevent').off('click.vy_ms__CLOSE_EVENT').on('click.vy_ms__CLOSE_EVENT',function(e){
					evstop(e,1);

					self.destroyThisCall(this,$html);
					
				});
				
				// remove the half minimize button for mobile devices.
				if(is_smartphone()){
					$html.find('#vy_call_halfmin_btn').remove();
				}
	},
	this.answerThisCall = async function($html){
		
		if (!navigator.mediaDevices)
			return self.browser_dosent_support_mediadevice();
		
		// stop incoming call sound
		self.stop_sound('incoming');
		
		// connecting status
		self.call_status('answered');
		
        // Get audio/video stream
 
		let constraints = self.media_type == 'audio' ? { audio: true, video:false } : { audio: true, video:{facingMode: "user"}}; 
		await navigator.mediaDevices.getUserMedia(constraints).then(stream => {
			
 
            // Set your video displays
            self.localStream = stream;

			// answer notification
			self.socket.emit("call_answered", socketId(self.call.metadata.user_id));
			
 			self.createAnswer();
		
        }).catch(function(err){
			 self.show_error_popup(err+'.'+self.microphone_camera_err_msg);
			 self.call_ended('error',false,err);
			 self.socket.emit("call_unavailable_stream", socketId(self.recipientid));

        });
		 
		
	},
	this.createAnswer = function(btn){
		
	 
		// remove reject class
		__j('#vy_ms__decline_buttonevent').removeClass('__reject').addClass('__endcall');
		
		
		self.media_elements.removeClass('__none');
						
		if(is_smartphone())
			self.media_elements.addClass('_mobileview');
		
		self.media_elements.find('#vy-ms__user-video-element').draggable();
		
		self.set_media_elements(self.media_type);
		
		// Set my audio/video displays
		self.user_media_element[0].srcObject = self.localStream;
		
		self.call.answer(self.localStream);
		
		
		
		// Wait for stream on the call, then set peer video display
        self.call.on('stream', function(stream) {

			if(self.media_type == 'video'){
			
				self.call_window.addClass('vy_ms__videocall');
			}
            setTimeout(function(){
			
			
					  
					  self.recipient_media_element[0].srcObject = stream;
					  self.recipient_media_element[0].onloadedmetadata = function(e) {
					  self.socket.emit("call_started", socketId(self.call.metadata.user_id));
						self.call_established();
						self.start_timer();
					  };
			 
				
				
			
			},100);
        });
        // UI stuff
        self.call.on('close', function(){self.call_ended('finished');});
	},
	this.start_timer = function(){
		
		clearTimeout(self.timer_interval);
		
 
		let hoursLabel;
		let minutesLabel;
		let secondsLabel;
		let totalSeconds = 0;
 
		
		self.setTime = function() {
		  ++totalSeconds;
 
			hoursLabel = Math.floor(totalSeconds /3600);
			minutesLabel = Math.floor((totalSeconds - hoursLabel*3600)/60);
			secondsLabel = totalSeconds - (hoursLabel*3600 + minutesLabel*60);
			
			if(hoursLabel < 10)
				 hoursLabel = "0"+hoursLabel;
			if(minutesLabel < 10)
				 minutesLabel = "0"+minutesLabel;
			if(secondsLabel < 10)
				 secondsLabel = "0"+secondsLabel;
			 
		  self.total_time = hoursLabel + ':'+minutesLabel+':'+secondsLabel;
		  self.status.text( self.total_time );
		  self.set_header_status( self.total_time );
		  self.timer_interval = setTimeout(self.setTime,1000);
		   
			if(!navigator.onLine){
			  self.show_err_msg('network');
			 } 
		} 

		self.setTime();
		


	},
	this.set_header_status = function(txt){
		
		self.header_status.html( '&nbsp;&#9866;&nbsp;' + txt );
		
	},
	this.destroy_timer = function(){
		
	 
		clearTimeout(self.timer_interval);
		self.setTime = function(){};
		/*
		if(self.timer){
			
			
			self.timer.stop();
			self.timer.reset();
			self.timer.removeEventListener('secondsUpdated');
			
		}*/
		
	}
	this.destroyThisCall = function(btn,$html){
		 
				btn = __j(btn) || false;
				const call_initiator = btn ? btn.hasClass('__callinitiator') : false;
				
				// decline answer
                // send notification that the respective user rejected the call
                if(btn && btn.hasClass('__reject')){
					self.call_ended('rejected',call_initiator);
				}else if (btn && btn.hasClass('__endcall') && !btn.hasClass('__reject')){
					
					self.call_ended('finished',call_initiator);
				} 
						if(self.localStream) {
						 
							if(self.media_type == 'video'){
								
							//self.localStream.getVideoTracks().forEach(track => track.stop());
							self.localStream.getVideoTracks()[0].stop();
							self.localStream.getAudioTracks()[0].stop();
							
							} else {
								
							//self.localStream.getAudioTracks().forEach(track => track.stop());
							self.localStream.getAudioTracks()[0].stop();
								
							}
							self.localStream = false;
						}
 
						// stop sounds
						self.stop_sound('all');
						
						// remove timer
						self.destroy_timer();
		
						// destroy peer call
						if(self.call)
							self.call.close();
						
						//if(self.peer_conn && btn.hasClass('__reject'))
							//self.peer_conn.send({'action':'decline'});
						
						// destroy resizing
						self.disableResize($html);
						// destroy drag
						self.disableDrag($html);
 
						self.destroy_sounds();
						setTimeout(function(){
							
							$html.remove();
							self.set_peer_status('available');
						},10);
						
						self.callerid = 0;
						self.total_time = !1;
						self.call_initiated = !1;
						
						clearTimeout(self.close_call_click_timeout);
						clearTimeout(self.busy_status_timeout);
						self.play_music_plugin();
		
	},
	this.set_peer_status = function(status){
		
		const send = jAjax(self.ajax_url,'post',{'cmd':'set-peer-status','action':status});
	}
	this.focusCallWindow = function(){
		
			self.call_window.removeClass('minimized').addClass('likeclose'); 
			self.call_window.find('#vy_call_js_draggable').center();
			self.enableResize(self.call_window);
			self.enableDrag(self.call_window);
			
	},
	this.enableDrag = function($html){
		const draggable = $html.find('#vy_call_js_draggable');
		
		if(!draggable.is(':data(ui-draggable)'))
			draggable.draggable({ handle: "#vy_js_calls_header",scroll: false });

	},
	this.disableDrag = function($html){
		const draggable = $html.find('#vy_call_js_draggable');
		
		if(draggable.is(':data(ui-draggable)'))
			draggable.draggable( "destroy" );
		
	},
	this.enableResize = function($html){
		const resizable = $html.find('#vy_call_js_draggable');
		
		if(!resizable.is(':data(ui-resizable)'))
			resizable.resizable({ handles: "n, e, s, w, se, nw", minHeight: 450, minWidth:190 });
		
	},
	this.disableResize = function($html){
		const resizable = $html.find('#vy_call_js_draggable');
		
		if(resizable.is(':data(ui-resizable)'))
			resizable.resizable( "destroy" );
	},
	this.peer_open = function(id){
		
		self.last_peer_id = id;
		
	},
	this.peer_disconnected = function(){
		
				clearTimeout(self.reconnectPeerTimeout);
				self.peer.id = self.last_peer_id;

				self.peer._lastServerId = self.last_peer_id;

				if(self.peerJS_reconnect_times <= self.reconnectPeerTimesCount) {
				self.reconnectPeerTimeout = setTimeout(function(){
				self.peer.reconnect();
				self.peerJS_reconnect_times++;
				},5000);

				}else{
					clearTimeout(self.reconnectPeerTimeout);
					console.log('Sorry, the system can not connect to peerJS, this mean your video/audio calling will not work.');	
					self.set_peer_status('cant_receive_signal');
					
				}
		
	}
	this.checkSafari = function() {
  let seemsChrome = navigator.userAgent.indexOf("Chrome") > -1;
  let seemsSafari = navigator.userAgent.indexOf("Safari") > -1;
  return seemsSafari && !seemsChrome;
},
	this.connect = function(){

 


        self.peer = new Peer(self.peer_uniq_id, {
			license: {code: messenger_code,domain: window.location.hostname,v:vy_ms_v},
            host: PEER_HOST_NAME,
            port: PEER_PORT,
			key:'peerjs',
			reconnectTimer: 1000, 
			serialization : "json",
			iceTransportPolicy: 'relay', 
            debug: 0,
			path:PEER_PATH,
            metadata: {
 
                'user_name': _U.fn,
                'user_avatar': _U.p,
                'user_id': _U.i,
				'peer_id': self.peer_uniq_id

            },
 
   config: {
        'iceServers': [
            { url: iceservers_stun,
                credential: iceservers_cr,
                username: iceservers_un
				},
            {
                url: iceservers_turn,
                credential: iceservers_cr,
                username: iceservers_un
            }
        ]
    }
  

        });
 
 
		
		self.peer.on('open', self.peer_open); // (id)
		self.peer.on('disconnected', self.peer_disconnected); // ()



 
		self.socket.emit('update_peer_id', JSON.stringify({'Userid': socketId(_U.i), 'Peer_id': self.peer_uniq_id}));
 

    self.peer.on('open', function(id) {

        console.log(id);
		
		// update peer id
		self.update_peer_id(id);
		
		self.set_peer_status('available');
		
    });
	self.peer.on('close', function(call,a,b,c) { 
 
	console.log('Close: declined');
	});
	self.peer.on('connection', function(dataConnection) { 

 
	//console.log(dataConnection);
	});

    // Receiving a call
    self.peer.on('call', function(call) { 

		self.answer_popup(call); 
		self.set_peer_status('another_call');

    });

    // error
    self.peer.on('error', function(err) {
      
const send = jAjax(self.ajax_url,'post',{'cmd':'logerr','err':JSON.stringify(err)});
		self.show_err_msg(err.type);
	


    });
	
	self.mob_last_window_focus = new Date().getTime();
	/*self.socket.on('update_peer_id',function(Obj){
		 
		let userid = Obj.Userid;
		let curr_peer_id = Obj.Peer_id;
		if(userid != _U.i) return;
		
		if(getMobileOperatingSystem() == '_ios'){
			
			
			setInterval(function() {
 
				now = new Date().getTime();
				if(now - self.mob_last_window_focus > 1000) {//if it's been more than 5 seconds
 
			 
						if(curr_peer_id != self.peer_uniq_id && userid == _U.i)
							window.location.reload();
						
				 
				}
				self.mob_last_window_focus = now;
			}, 500);
			
		} else {
			
		__j(window).off("blur.update_peer_id focus.update_peer_id").on("blur.update_peer_id focus.update_peer_id", function(e) { 
			
			setTimeout(function(){
				if( vy_ms__window_tab_active && curr_peer_id != self.peer_uniq_id && userid == _U.i)
					window.location.reload();
				
			},500);

		});
		}
		
	
 

 
	});*/
	
	// end call when window close
	__j(window).off("unload.vy-ms__offline_peer beforeunload.vy-ms__offline_peer").on("unload.vy-ms__offline_peer beforeunload.vy-ms__offline_peer", function(){
		return vy_calls.peerIsOffline();

				 
	}); 
	self.enable_sounds_for_ios();
		
	},
	this.peerIsOffline = function(){
 
  		self.set_peer_status('offline');
		
		if(self.total_time)
			self.call_ended('finished');
		else
			self.call_ended('rejected');
	},
	this.show_err_msg = function(msg){
		
		switch(msg){
			
			case 'browser-incompatible':
				self.call_ended('error',false,"The client's browser does not support some or all WebRTC features that you are trying to use.");
			break;
			
			case 'disconnected':
				self.call_ended('error',false,"Disconnected from the server.");
				self.reconnectPeer();
			break;
			case 'invalid-id':
				self.call_ended('error',false,"An tehnical error ocurred.[INVALID ID]");
			break;
			case 'network':
				self.call_ended('error',false,"Network down. Lost or cannot establish a connection to the signalling server.");
			break;
			case 'peer-unavailable':
				self.call_ended('notif',false,"The user can not receive calls at the moment, try again later.");
			break;
			case 'server-error':
				self.call_ended('error',false,"Unable to reach the server.");
			break;
			case 'socket-error':
				self.call_ended('error',false,"An error from the underlying socket.");
			break;
			case 'socket-closed':
				self.call_ended('error',false,"The underlying socket closed unexpectedly.");
			break;
			case 'unavailable-id':
				self.peer.disconnect();
				self.reconnectPeer();
				self.call_ended('notif',false,"The user can not be reached at the moment, please try to reload your page.. and try again.");
			break;
			case 'webrtc':
				self.call_ended('error',false,"Tehnical error. Native WebRTC errors.");
			break;
		}
		
	},
	this.update_peer_id = function(id){
		
		const send = jAjax(self.ajax_url,'post',{'cmd':'update-peer-id','id':id});
		send.done(function(new_peer_id){
			//self.peer_uniq_id = new_peer_id;
			/*if(new_peer_id > 0 && self.peer && new_peer_id != self.peer_uniq_id){
				self.peer_uniq_id = new_peer_id;
				self.reconnectPeer();
			}*/
			
		});
		
	},
	this.enable_sounds_for_ios = function(){
			
		
            self.ms___test_sound = soundManager.createSound({
                // optional id, for getSoundById() look-ups etc. If omitted, an id will be generated.
                id: 'ms__test_sound',
                 url: THEME_URL+"/javascript/vaneayoung/sounds/tap.aac", 
                // optional sound parameters here, see Sound Properties for full list
                volume: 0, 
				autoPlay:false,
				type: 'audio/aac',
				onload:function(){ self.ios_simulated = "yes";this.destruct();} 
 
				 
            });
			soundManager.onready(function() {
			 
				soundManager.load('ms__test_sound');
 
			});
			// for IOS 
			if(is_smartphone())
			__j(document).off('touchstart.simulateIosAudio click.simulateIosAudio').on('touchstart.simulateIosAudio click.simulateIosAudio',function(){
			 if(self.ios_simulated == "yes") {__j(document).off('touchstart.simulateIosAudio click.simulateIosAudio'); return false;}
				
				if(typeof self.ms___test_sound == 'function') self.ms___test_sound.play(); 
				  
				 
			});
		
		
	},
	this.reconnectPeer = function(){
 
		self.peer.connect(self.peer_uniq_id, {
			license: {code: messenger_code,domain:window.location.hostname},
			host: PEER_HOST_NAME,
			port:PEER_PORT,
			debug: false,
			metadata: {

				'user_name': _U.fn,
				'user_avatar': _U.p,
				'user_id': _U.i,
				'peer_id': self.peer_uniq_id

			}

		});
	},
	this.disconnectPeer = function() {
		if(self.peer) self.peer.disconnect();
		
	},
	this.browser_dosent_support_mediadevice = async function(){
	
			ajaxLoading();
			const msg = "Your browser dose not support Video/Audio calls.";
			const send = jAjax(self.ajax_url,'post',{cmd:'call-error',msg:msg});
			send.done(function(html){
				 
				removeAjaxLoad();
				self.body.find('#vy-ms__call_error_popup_info').remove();
				self.body.prepend(html);
			});
			
			self.close_button.trigger('click');
			self.socket.emit("call_unavailable_stream", socketId(self.recipientid));
	},
	this.show_error_popup = function(msg){
		

			$.confirm({
				title: 'Disabled or not supported.',
				content: msg,
				type: 'red',
				typeAnimated: true,
				buttons: {

					close: function () {
					}
				}
			});
			
			if(self.close_button) self.close_button.trigger('click');
 	
	},
	this.start_call = async function(type,userid){
		
		if (!navigator.mediaDevices)
			return self.browser_dosent_support_mediadevice();
			 

        // Get audio/video stream
		let constraints = type == 'audio' ? { audio: true, video:false } : { audio: true, video:true }; 
		await navigator.mediaDevices.getUserMedia(constraints).then(stream => {
	 

            // Set your video displays
            self.localStream = stream;
			
			self.call_popup(type,userid); 
			
			
			
		
        }).catch(function(err){
			self.show_error_popup(err+'.'+self.microphone_camera_err_msg);
			self.call_ended('error',false,err);
			 
        });
		 
		
	},
	this.set_media_elements = function(type){
		self.recipient_media_element = type == 'video' ? __j('#vy-ms__recipient-video-element') : __j('#vy-ms__recipient-audio-element');
		self.user_media_element = type == 'video' ? __j('#vy-ms__user-video-element') : __j('#vy-ms__user-audio-element');
 
	},
	
	this.initiateCall = function(type,userid,local_stream){
	 
		self.set_media_elements(type);
		
		var send = jAjax(self.ajax_url,'post',{'cmd':'initiate-call','type':type,'recipient':escape(userid)});
 
		send.done(function(data){ 
		 
			const r = validateJson(data);
			
			if(r.blacklist >= 1)
				return self.call_ended('blacklist');
			
			if(r.peer_id <= 0)
				return self.userNotConnected();
			
			if(r.status == 'another_call')
				return self.call_ended('another_call');
			
			if(r.status == 'offline')
				return self.call_ended('offline');
			
			if(r.status == 'cant_receive_signal')
				return self.call_ended('cant_receive_signal');
						
				const options = {
					'metadata': {

							'user_name': _U.fn,
							'user_avatar': _U.p,
							'user_id': _U.i,
							'call_type':type

					},
					'constraints': {
						'mandatory': {
							'OfferToReceiveAudio': true,
							'OfferToReceiveVideo': true
						}
					}
				}
				
				
				 
			 

					//self.peer_conn = self.peer.connect(r.peer_id);
					self.play_sound('contacting');
					
					setTimeout(function(){
 
						self.user_media_element[0].srcObject = local_stream;
					
					},100);
 
			 
					
					// initiate call
					//setTimeout(function(){
						self.media_elements.removeClass('__none');
						
						if(is_smartphone())
							self.media_elements.addClass('_mobileview');
							
						self.media_elements.find('#vy-ms__user-video-element').draggable();
						self.set_peer_status('another_call');
						self.call = self.peer.call(r.peer_id, local_stream, options);
						self.call.on('stream', function(stream) {
							self.getRecipientStream(stream);
						});
						
						self.call.on("error", function (err) {
							
							//self.show_err_msg('network');
							
							self.set_peer_status('available');
							
						});
						// receive notifications
						self.get_notifications(self.call.metadata);
					 
						
					//},200);
			
		});
	

		
    },
	this.getRecipientStream = function(recipient_stream){
 
	  self.set_media_elements(self.media_type);
	  self.recipient_media_element[0].srcObject = recipient_stream;
		if(self.media_type == 'video') 
			 self.call_window.addClass('vy_ms__videocall');
 
		
	},
	this.stop_sound = function(which,no_prop){
		
		
		 
		switch(which){
			
			case 'contacting':setTimeout(function(){ self.ms__contacting_sound.stop(); },10);break;
			case 'ringing':setTimeout(function(){ self.ms__ringing_sound.stop() },10);break;
			case 'incoming':setTimeout(function(){ self.ms__incomming_call.stop(); },10);break;
			case 'busy':setTimeout(function(){ self.ms__busy_sound.stop(); },10);break;
			case 'noanswer':setTimeout(function(){ self.ms__noanswer_sound.stop(); },10);break;
			case 'all':
			setTimeout(function(){ 
	 
			self.ms__contacting_sound.stop();
			self.ms__ringing_sound.stop()
			self.ms__incomming_call.stop();
			self.ms__busy_sound.stop();
			self.ms__noanswer_sound.stop();
			
			},10);
		
			break;
			
		} 
		
		if(!no_prop) setTimeout(function(){self.stop_sound_propagate(which);},1500);
		
	},
	this.stop_sound_propagate = function(which){
		return self.stop_sound(which,1);
	},
	this.play_sound = function(which){

		
		switch(which){
			
			case 'contacting':self.ms__contacting_sound.play();break;
			case 'ringing':self.ms__ringing_sound.play();break;
			case 'incoming':self.ms__incomming_call.play();break;
			case 'busy':self.ms__busy_sound.play();break;
			case 'noanswer':self.ms__noanswer_sound.play();break;
 
		}
		
	},
 
	this.create_sounds = function(callback){
		
		 
            self.ms__incomming_call = soundManager.createSound({
                // optional id, for getSoundById() look-ups etc. If omitted, an id will be generated.
                id: 'ms_call_incoming',
                url: THEME_URL + "/javascript/vaneayoung/sounds/incoming_call.mp3", 
                // optional sound parameters here, see Sound Properties for full list
                volume: 100,
                autoPlay: false,
                onfinish: function() {
                    this.play();
                }
            });
            self.ms__ringing_sound = soundManager.createSound({
                // optional id, for getSoundById() look-ups etc. If omitted, an id will be generated.
                id: 'ms_call_ringing',
                url: THEME_URL+"/javascript/vaneayoung/sounds/call-ringing-2s.mp3",
                // optional sound parameters here, see Sound Properties for full list
                volume: 100, 
                autoPlay: false,
				type: 'audio/mp3',
				onfinish: function() {
					let that = this;
					setTimeout(function(){that.play();},900);
				}
 
            });
			
            self.ms__contacting_sound = soundManager.createSound({

                id: 'ms_call_contacting',
                url: THEME_URL+'/javascript/vaneayoung/sounds/call-connecting.mp3',
                // optional sound parameters here, see Sound Properties for full list
                volume: 100, 
                autoPlay: false,
				type: 'audio/mp3',
				onfinish: function() {
					this.play();
				}
            });

            self.ms__busy_sound = soundManager.createSound({

                id: 'ms_call_busy',
                url: THEME_URL+'/javascript/vaneayoung/sounds/call-busy.mp3',
                // optional sound parameters here, see Sound Properties for full list
                volume: 100, 
                autoPlay: false,
				type: 'audio/mp3' 
            });

            self.ms__noanswer_sound = soundManager.createSound({

                id: 'ms_call_noansnwer',
                url: THEME_URL+'/javascript/vaneayoung/sounds/call-noanswer.mp3',
                // optional sound parameters here, see Sound Properties for full list
                volume: 100, 
                autoPlay: false,
				type: 'audio/mp3' 
            });


			soundManager.onready(function() {
 
				 
				soundManager.load('ms_call_incoming');
				soundManager.load('ms_call_ringing');
				soundManager.load('ms_call_contacting');
				soundManager.load('ms_call_busy');
				soundManager.load('ms_call_noansnwer');
				
				if(typeof callback == 'function')
					callback();
 
			});
			

 
 
 
 
	
	},
 
	this.destroy_sound = function(id,reconstruct){
		//id.destruct();
		
		if(reconstruct){
			self.destroy_sounds();
			
			
			self.create_sounds();
			
		}
			
	},
	this.destroy_sounds = function(){
		
	 
			soundManager.stopAll();
			self.ms__contacting_sound.destruct();
			self.ms__ringing_sound.destruct();
			self.ms__incomming_call.destruct();
			self.ms__busy_sound.destruct();
			self.ms__noanswer_sound.destruct();
			
			
		
	},
	this.call_status = function(c,seconds,metadata){
		
		let c_status = function(title,header_title){
		
			header_title = header_title || title;
			self.set_header_status( header_title );
			self.status.text(title);
		
		}
		
		switch(c){
		
		
			case 'connecting':
			c_status(lang['Call_Contacting...']);
			break;
		
			case 'rejected':
			c_status(lang['Call_rejected']);
			self.call_ended('rejected');
			break;
			case 'reject_status':
			c_status("I'm Busy! I call you back later.","Busy");
			
			break;
			case 'started':
			c_status(seconds);
 
			break;
			
			case 'callended':
			c_status(lang['call_ended'],seconds);
			break;
			
			case 'no_answer':
			c_status(lang.call_no_answer,lang.call_no_answer);
			break;
			
			case'another_call':
			c_status("Is on another call.","Line Busy");
			break;
			
			case 'ringing':
			c_status(lang['Call_Ringing...']);
			break;
			case 'disconected':
			c_status("Recipient is disconnected.","Disconnected");
			break;
			case 'answered':
			c_status(lang['Call_Connecting...']);
			break;
			 
			case 'offline':
			c_status("I'm offline, i will call back soon.","Offline");
			break;
			
			case 'unavailable_stream':
			c_status(lang.call_recipient_err_stream.replace('%uname',metadata.user_name).replace('%calltype',metadata.call_type),'Call ended.');
			self.call_ended('no_stream');
			break;
		
		
		}
		
	
		
	},
	this.call_established = function(){
		
		if(!is_smartphone()) __j('#vy_call_halfmin_btn').trigger('click.halfminimizeMessCallWindow');
		
	},
	this.get_notifications = function(metadata){
		
		if(self.socket_notif_created) return;
		
		self.socket_notif_created = 1;
		
		// user is connected, call him
		self.socket.on("call_user_connected", function(uid){
	
			//if(uid != _U.i) return;
 
			if(self.call_1_ended) return;
			
			
			self.stop_sound('contacting');
		
			self.play_sound('ringing');

			
			self.call_status('ringing');
			
			self.ringing_timeout = setTimeout(function(){
				
				self.call_ended('no-answer',1);
				
			},60000);

		});
		
		// user rejected the call
		self.socket.on("call_rejected", function(uid){

			self.call_status('rejected');
		});
		
		// user accepted the call
		self.socket.on("call_answered", function(uid){

			self.stop_sound('all');
			self.call_status('answered');

		});
		
		// stream unavailable
		self.socket.on("call_unavailable_stream", function(uid){
 
			self.call_status('unavailable_stream',false,metadata);
 
		});
		
		// call started
		self.socket.on("call_started", function(uid){
			
			
			setTimeout(function(){
				self.stop_sound('ringing');
				self.stop_sound('all');
			},100);
			self.start_timer();
			self.call_established();
			if(self.ringing_timeout) clearTimeout(self.ringing_timeout);
		});


		// recipient hang up the call
		self.socket.on("call_finished", function(uid){ 
	 
				self.call_ended('finished');
		});
		
		// call no answer
		self.socket.on("call_stopped", function(uid){ 
 
				self.call_ended('finished');
		});
		
	},
	this.call_ended = function(c,initiator,err_msg){
	 
		
		if(self.call_1_ended || !self.call_initiated) return;
		if(self.timer_interval) clearTimeout(self.timer_interval); 
		
		if(c == 'blacklist'){
			
			setTimeout(function(){
				self.play_sound('busy');
			},50);
			 
			self.busy_status_timeout = setTimeout(function(){
				self.set_header_status( "Blacklisted" );
				self.status.text('You can not call this user. You are in blacklist.');
			},100);

			self.close_call_click_timeout =  setTimeout(function(){
				
				self.stop_sound('all');
				self.close_button.trigger('click');
				
			},9000);
		} 
		
		if(c == 'rejected'){
			
			setTimeout(function(){
				self.stop_sound('ringing');
				self.play_sound('busy');
			},100);
			self.socket.emit("call_rejected", socketId(self.recipientid));
			self.busy_status_timeout = setTimeout(function(){self.call_status('reject_status');},1500);
 
			
			self.close_call_click_timeout =  setTimeout(function(){
				
				self.stop_sound('all');
				self.close_button.trigger('click');
				
			},9000);
		} 
		
		if(c == 'another_call'){
			
			setTimeout(function(){
				self.stop_sound('all',1);
				self.play_sound('busy');
			},50);
			 
			self.busy_status_timeout = setTimeout(function(){self.call_status('another_call');},100);
			self.sendMessage('missed');
			
			self.close_call_click_timeout =  setTimeout(function(){
				
				self.stop_sound('all');
				self.close_button.trigger('click');
				
			},9000);
		}
		
		if(c == 'cant_receive_signal'){
			
			setTimeout(function(){
				self.stop_sound('all',1);
				self.play_sound('busy');
			},50);
			 
			self.busy_status_timeout = setTimeout(function(){self.call_status('disconected');},100);
			self.sendMessage('missed');
			
			self.close_call_click_timeout =  setTimeout(function(){
				
				self.stop_sound('all');
				self.close_button.trigger('click');
				
			},9000);
		}
		if(c == 'offline'){
			
			setTimeout(function(){
				self.play_sound('busy');
			},50);
			 
			self.busy_status_timeout = setTimeout(function(){
				self.call_status('offline');
			},100);
			self.sendMessage('missed');
			
			self.close_call_click_timeout =  setTimeout(function(){
				
				self.stop_sound('all');
				self.close_button.trigger('click');
				
			},9000);
		}
		if(c == 'no-answer'){
			
			setTimeout(function(){
				self.stop_sound('ringing');
				self.play_sound('noanswer');
			},100);
			self.socket.emit("call_stopped", socketId(self.recipientid));
 
			setTimeout(function(){
			 
				self.call_status('no_answer');
				
			},150);
 
			
			self.close_call_click_timeout =  setTimeout(function(){
				
				self.stop_sound('all');
				self.close_button.trigger('click');
				
			},18000);
			
		}

			
			

		if(c == 'error' || c == 'notif'){
			
			setTimeout(function(){
				self.stop_sound('all',1);
				self.play_sound('busy');
			},50);
			 
			self.busy_status_timeout = setTimeout(function(){

				self.set_header_status( c == 'error' ? "Error" : "Call finished" );
				self.status.text(err_msg);
				},100);
 
			
			self.close_call_click_timeout =  setTimeout(function(){
				
				self.stop_sound('all');
				self.close_button.trigger('click');
				
			},9000);
			
			
			
		}
		
		if(c == 'no_stream')
			
		
		{
			
			
			setTimeout(function(){
				self.stop_sound('all',1);
				self.play_sound('busy');
			},50);
			 
 
			self.close_call_click_timeout =  setTimeout(function(){
				
				self.stop_sound('all');
				self.close_button.trigger('click');
				
			},9000);
			
			
		}
		
		
		if(c == 'finished'){
			
			setTimeout(function(){
				self.stop_sound('ringing');
				self.stop_sound('all');
			},100);
 

			
			self.call_status('callended',self.total_time);
			self.socket.emit("call_finished", socketId(self.recipientid));




				self.close_call_click_timeout =  setTimeout(function(){
					
					self.close_button.trigger('click');
					
				},3000);

		}
		
		

		
		if(self.hangup_button.hasClass('__callinitiator')){
			if(c == 'finished' && self.total_time)
				self.sendMessage('ended',self.total_time);
			else
				self.sendMessage('missed');
		} 
		self.call_window.removeClass('vy_ms__videocall');
		self.answer_button.hide();
		self.hangup_button.hide();
		self.close_button.show();
		if(self.call) self.call.close();
		self.call_1_ended = 1;
		
		
	},
	
	this.sendMessage = function(c,time){
	
		
		if(self.last_message_send) return;
		
		let t, ev = window.event || $.Event();
	 
		switch(c){

			case 'missed':
			t = '[missedcall]'+_U.i+'-'+self.recipientid+'-'+self.media_type+'[/missedcall]';
			break;
			case 'ended':
			t = '[callended]'+_U.i+'-'+self.recipientid+'-'+self.media_type+'-'+time+'[/callended]';
			break;

		}
		
		if(t)
			messenger.send(0, ev, t, self.recipientid);
		
		
		//$.post( self.ajax_url, { cmd: "sendMessage", userid: escape(self.recipientid), text:t});
		
		self.last_message_send = 1;
		
		setTimeout(function(){
			self.last_message_send = 0;
		},3000);
	 
	},
	this.userNotConnected = function(){
		
		
		self.call_ended('cant_receive_signal');
		
	}
 
}


 