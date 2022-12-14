<?php
if (file_exists('assets/init.php')) {
    require 'assets/init.php';
} else {
    die('Please put this file in the home directory !');
}
ini_set('max_execution_time', 0);
function check_($check) {
    $siteurl           = urlencode(getBaseUrl());
    $arrContextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false
        )
    );
    $file              = file_get_contents('http://www.wowonder.com/purchase.php?code=' . $check . '&url=' . $siteurl, false, stream_context_create($arrContextOptions));
    if ($file) {
        $check = json_decode($file, true);
    } else {
        $check = array(
            'status' => 'SUCCESS',
            'url' => $siteurl,
            'code' => $check
        );
    }
    return $check;
}
$updated = false;
if (!empty($_GET['updated'])) {
    $updated = true;
}
if (!empty($_POST['code'])) {
    $code = check_($_POST['code']);
    if ($code['status'] == 'SUCCESS') {
        $data['status'] = 200;
    } else {
        $data['status'] = 400;
        $data['error']  = $code['ERROR_NAME'];
    }
    header("Content-type: application/json");
    echo json_encode($data);
    exit();
}
if (!empty($_POST['query'])) {
    $query = mysqli_query($sqlConnect, base64_decode($_POST['query']));
    if ($query) {
        $data['status'] = 200;
    } else {
        $data['status'] = 400;
        $data['error']  = mysqli_error($sqlConnect);
    }
    header("Content-type: application/json");
    echo json_encode($data);
    exit();
}
if (!empty($_POST['update_langs'])) {
    $data  = array();
    $query = mysqli_query($sqlConnect, "SHOW COLUMNS FROM `Wo_Langs`");
    while ($fetched_data = mysqli_fetch_assoc($query)) {
        $data[] = $fetched_data['Field'];
    }
    unset($data[0]);
    unset($data[1]);
    unset($data[2]);
    function Wo_UpdateLangs($lang, $key, $value) {
        global $sqlConnect;
        $update_query         = "UPDATE Wo_Langs SET `{lang}` = '{lang_text}' WHERE `lang_key` = '{lang_key}'";
        $update_replace_array = array(
            "{lang}",
            "{lang_text}",
            "{lang_key}"
        );
        return str_replace($update_replace_array, array(
            $lang,
            Wo_Secure($value),
            $key
        ), $update_query);
    }
    $lang_update_queries = array();
    foreach ($data as $key => $value) {
        $value = ($value);
        if ($value == 'arabic') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', '?????? ???????? ?????????? ???? ???? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', '?????? ?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', '?????????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', '?????????? ???? ???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', '?????? ???????? ???? ???????? ???? ?????????????? ?????????????? ???????? ???????????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', '?????? ?????? ?????? ?????????????? ?????? ?????? ??????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', '?????? ?????? ?????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', '???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', '???? ?????? ???????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', '???? ?????????? ???????????? ???????? ????!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', '?????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', '?????????? ?????????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', '?????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', '?????? ???????? ??????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', '???? ?????? ???????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', '?????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', '?????????? ?????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', '?????? ?????????? ???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', '?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', '???? ?????? ?????????? ???? ?????? ???????? ?????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', '???? ?????????? ???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', '???????? ?????????? ?????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', '???????? ???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', '?????? ?????? ?????? ???????? ???????????????? ???? ???????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', '???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', '???????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', '?????? ???????????????? ???????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', '?????????????? ???? ???????? ???? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', '???? ?????? ???????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', '?????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', '???? ?????? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', '???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', '???? ?????? ???????????? ?????? ?????????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', '??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', '?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', '???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', '?????? ???? ?????????? ??????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', '?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', '???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', '???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', '?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', '???????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', '?????? ???? ?????? ?????????? ???????? ?????????? ???????????????? ???? ???????? 60 ???????? ???? ?????????? ???????????? ?????????? ?????????????? ?????????????? ?????? "??????????????".');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', '?????? ???? ?????? ?????????? ?????????? ?????????????? ?????????? ?????????????? ?????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', '??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', '???????????????? ??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', '???????????? ??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', '???????????? ???????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', '???????????? ??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', '???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', '???????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', '?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', '?????????? #?? s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', '???? ?????? ???????????? ?????? ?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', '?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', '???? ?????? ?????????????? ???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', '???? ???????? ???? ???????? ???????? ?????????? URL ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', '?????? ???????? ???? ???????? ???? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', '???????? ???????? ???????? ???? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'URL ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', '???? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', '???????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', '???????? ?????? ?????????????????? ???????????? ?????? ?????? ??????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', '?????????? ???????????????? ??????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', '?????????????? ???? ???????? ???? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', '???? ?????????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', '???? ?????????? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', '?????? ???????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', '?????????? ?????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', '?????? ???????????????? ?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', '???????????? ?????????? ???? ?????? ???????????????? ??????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', '??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', '???????? ?????????? ?????????? ?????? Enter');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', '???????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', '???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', '???????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', '?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', '???????? ???? ?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', '???????? ???? ?????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', '???????????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', '???? ?????? ???????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', '???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', '???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', '?????????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', '?????????? ???????? ?????????? ... ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', '???????????? ??????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', '???????? ?????????? ???? ???????? ???? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', '?????? ?????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', '?????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', '?????????? ?????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', '?????????? ?????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', '???? ???????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', '?????????? ???? ?????????? ?? #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', '???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', '?????????? ?????????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', '?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', '???????? ?????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', '?????? ?????? ?????????????? ???? ???????? ???? ???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', '?????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', '?????????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', '?????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', '?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', '?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', '?????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', '???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', '???????????????? ?????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', '???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', '?????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', '???????? ?????????????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', '???????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', '???????????? ?????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', '???????????? ?????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', '???????????? ?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', '???????????? ?????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', '???????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', '???????????? ?????????? ??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', '???????? ???????????? ?????????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', '?????????? ???? ?????????????? ??????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', '???????????? ?????????? ???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', '?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', '???? ?????? ?????????? ?????? ???????? ?????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', '?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', '?????? ?????? ?????????????? ?????????? ?????????? ?????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', '?????????? ???? ?????????????? ??????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', '???????????????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', '?????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', '???????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', '?????????? ???????????????? URL.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', '???????????? ?????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', '?????????? ???????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', '???????????? ?????????? ?????????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', '???????????? ?????????? ??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', '???? ?????????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', '?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', '???? ?????? ?????????? ?????? ???????? ?????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', '???? ?????????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', '?????????? ?????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', '?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', '?????????? ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', '?????? ?????????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', '?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', '???? ?????? ?????????? ?????? ???????? ?????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', '???? ?????????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', '?????????? ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', '???????????? ?????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', '?????????? ?????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', '???????????? ???? ?????? ???? ?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', '???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', '???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', '???????????? ?????????????? ???? ???????? ???? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', '???????? ?????????????? ???? ???????? ???? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', '???????? ???????????? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', '???????? ???????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', '???? ?????????? ?????????????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', '???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', '???????? ???? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', '?????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', '?????????? ?????????? ???????? ?????????????? ???????????? ????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', '?????????????? ???? ???????? ???? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', '???? ?????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', '?????????? ?????????????? ?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', '???? ?????????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', '?????????? ?????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', '???? ?????????? ?????????????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', '?????????? ???????????? ???? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'tiers.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', '???????? ???? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', '???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', '?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', '?????????? ???????? ???????????? ?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', '?????????????? ???? ???????????? ?????????? ???????? ???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', '?????????????? ?????? ???????????? ?????????? ?????? ???????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', '?????????????? ???? ???????????? ?????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', '???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', '?????????? ???? ???????? ???? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', '?????????????? ???? ???????? ???? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', '???????? ???????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', '?????? ?????????? ?????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'tier ???? ?????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', '?????? ?????????????? ?????????? ????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', '???? ?????? ?????????? ???? ?????? ???????? ?????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', '?????????????? ???????? ???? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', '???????????? ???????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'aragonese.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', '???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', '?????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', '????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', '??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', '?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'bokm??l ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Norwegian Nynorsk.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitan.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'oriya.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'oromo.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', '?????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'quechua.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', '?????????????? ??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', '??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', '???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanese.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'TWI.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'uyghur.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', '???????? ???? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', '?????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', '???? ???????? ???????????? ?????????? ????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', '?????? ???????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', '?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', '???????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', '?????? ???????? ?????????????? ???????? ??????????????????. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', '?????????? ???? ???????? ???? {site_name}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', '???????? ?????????????? ?????? ???????????? ?????? ???????? ???? ????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', '?????????? ?????? pdf');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', '???? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', '???? ?????? ?????????? ?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', '?????? ?????? ???????? ???? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', '???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', '???? ?????????? ?????? ?????????????????? ???????????? ???? ???????? ???? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', '???? ?????????? ?????? ???????????? ???????? ???? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', '???? ?????????? ?????? ???????????? ???????? ???? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', '???? ???????????? ?????????????? ?????????? ????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- ???????? ???????? ?????????????????? ???????????? ???? ??????. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<h4> 1- ???????? ???? ???????? ?????????? ?????????? ???? ??????. </ h4> Lorem Ipsum Dolor Sit Amet?? Consectedur ALIT ELIT?? SED Do Eiusmod Incididund Incididunt UT Labore Et Dolore Magna Aliqua. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<H4> 1- ???????? ???????? ?????????????????? ???????????? ???? ??????. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', '???????????? ???????????? ?????????? ????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'coinbase.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', '???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', '?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', '???? ???????? ?????? ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', '???????????? ?????? ??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', '???? ?????? ?????????? ?????? ???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', '???? ?????? ?????????? ?????? ???????? ?????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', '???????????? ?????????? ?????????????? ???????? ???????????? ?????? ?????? ?????????? ????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', '?????????? ???? ????????????????!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', '?????????? ???????????? ?????? ???????? {site_name} ???????????????? ????????????????!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', '???????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', '???? ???????????? ???????? {site_name}!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', '?????? ???????????????????? ?????????????????? ???????????? ?????????? ???????????? ?????????????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', '???? ???????? ???? ???????? ?????????? ?????????????? ??????????.');
        } else if ($value == 'dutch') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'U moet een tekst of afbeelding toevoegen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'Voeg toe aan winkelmandje');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Verwijderen van winkelwagen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'Betaal per portemonnee');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'Je hebt niet genoeg balans om te kopen, vul je portemonnee bij.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'U staat op het punt om een ??????pro-lid te upgraden.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'Je staat op het punt te doneren.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'Bedrag is vereist');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'Financiering wordt niet gevonden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', 'Betaling succesvol gedaan, dank u!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', 'Koop nu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Totale itemeenheden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', 'Artikeleenheden zijn vereist');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', 'Momenteel niet beschikbaar.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', 'Uitchecken');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'Geen items gevonden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Totaal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'Mijn adressen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'Voeg nieuw toe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Nieuw adres toevoegen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Uw adres is succesvol toegevoegd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'Verwijder uw adres');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', 'Weet je zeker dat je dit adres wilt verwijderen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'verander adres');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Uw adres is succesvol bewerkt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'Voeg alstublieft een nieuw adres toe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'Selecteer een adres');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', 'Betalingswaarschuwing');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', 'Je staat op het punt om de items te kopen, wil je doorgaan?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Winkelwagen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', 'Items');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'Terug naar winkel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Sommige producten zijn niet op voorraad.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'Adres kan niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Adres niet gevonden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'Winkelwagen is leeg');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Uw bestelling is succesvol geplaatst');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'Gekocht');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'Geen aangekochte items gevonden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Volgorde');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'Factuur downloaden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'ID is vereist');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'Je hebt nog niet gekocht.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Bestellen niet gevonden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'Bestel Details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Schrijf recensie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Vraag een terugbetaling');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'Tracking details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Bezorgadres');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'Als de bestelstatus niet is ingesteld op afgeleverd binnen 60 dagen na de besteldatum, wordt deze automatisch verzonden naar "geleverd".');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'Als de bestelling niet daadwerkelijk is afgeleverd, kan de koper een terugbetaling aanvragen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Geplaatst');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', 'Betalingen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'Subtotaal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Verkoopfactuur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Naam van de verkoper');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Verkoper e-mail');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Factuur aan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', 'Betalingsdetails');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Totaal verschuldigd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'banknaam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Factuur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Item');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Bestellingen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'Geen bestellingen gevonden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', 'Producten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Titel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', 'Geannuleerd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Geaccepteerd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Ingepakt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Verzenden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'Commissie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Uiteindelijke prijs');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'Volg nummer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Koppeling');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', 'Tracking-informatie is succesvol opgeslagen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', 'Tracking-URL kan niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', 'Tracking-nummer kan niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'Voer een geldige URL in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'Site URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Afgeleverd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'Leg de reden uit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', 'Uw verzoek wordt beoordeeld, we nemen eenmaal contact op met u.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'Beoordeling');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'Indienen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', 'Review Content is vereist.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'beoordeling kan niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', 'Uw beoordeling is ingediend.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'Bestelstatus is gewijzigd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'Nieuwe bestellingen zijn geplaatst');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'Tracking-info toegevoegd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', 'Uw product is goedgekeurd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', 'Uw product wordt momenteel beoordeeld.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Vragen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', 'Schrijf een antwoord en druk op ENTER');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'Antwoord om te antwoorden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'beantwoordde je vraag');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'antwoordde op je antwoord');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', 'vond je vraag leuk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', 'vond je antwoord leuk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'Genoemde je op een antwoord');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'Ik heb je op een vraag genoemd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Geverifieerde aankoop');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'Geen reviews gevonden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'vraag anoniem');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Vraag een vriend');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Zoek naar vrienden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'Wat, wanneer, waarom ... vraag');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'Vraag is vereist.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'Selecteer alstublieft wie u wilt vragen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'vroeg je een vraag');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Vragen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', 'Mensen vonden deze vraag leuk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', 'Mensen vonden dit antwoord leuk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'Geen antwoorden om te laten zien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', 'Zoek naar mensen en #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Vragen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Trending tweets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', 'Mensen vonden deze tweet leuk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'vond je tweet leuk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'Selecteer een bestand om te uploaden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'Ontgrendel deze inhoud door een patroon te worden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', 'Lid worden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Patrum-lidmaatschap Prijs');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'Ervaring');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'Voeg nieuwe ervaring toe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', 'Bedrijfsnaam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', 'Type werkgelegenheid');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', 'Full time');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', 'Deeltijd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Eigen baas');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Freelance');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'Contract');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'Stage');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', 'Stage');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'Seizoensgebonden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Industrie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'Voer een titel in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'Voer een bedrijfsnaam in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'Voer een werkgelegenheidstype in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'Voer een locatie in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'Voer een startdatum in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'Voer een industrie in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'Voer een beschrijving in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'Kies een juiste datum.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Ervaring met succes gemaakt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'Voer een geldige link in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'Verwijder je ervaring');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', 'Weet je zeker dat je deze ervaring wilt verwijderen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'Bewerk ervaring');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'U bent niet de eigenaar, u kunt deze actie toepassen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Ervaring met succes bijgewerkt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Certificeringen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Licenties en certificaten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'Voeg nieuw certificaat toe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Uitgevende organisatie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'Referent-ID');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'Referent-url');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'Voer een uitgevende organisatie in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'Datum van publicatie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Uiterste houdbaarheidsdatum');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'Voer de uitgifte-datum in.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'Voer een naam in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Uw certificaat is gemaakt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'Verwijder uw certificaat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', 'Weet u zeker dat u dit certificaat wilt verwijderen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', 'Bewerk certificaat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Uw certificaat is bijgewerkt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Projecten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'Voeg nieuw project toe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Naam van het project');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', 'Geassocieerd met');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'Project URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Uw project is toegevoegd.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'Verwijder uw project');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', 'Weet je zeker dat je dit project wilt verwijderen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Project bewerken');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Uw project is bijgewerkt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'Vaardigheden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'Talen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'Open voor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Een nieuwe baan vinden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Het verlenen van diensten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', 'In dienst nemen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', 'Voeg taakvoorkeuren toe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Vertel ons wat voor soort werk je open bent');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', 'Werkplekken');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', 'Titels');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'Ter plekke');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'Hybride');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', 'Op afstand');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', 'Typen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Tijdelijk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', 'Werklocatie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', 'Functie kan niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', 'Werklocatie kan niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'Selecteer een werkplek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'Selecteer een taaktype');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', 'Jobvoorkeuren zijn bijgewerkt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', 'Open voor het werk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'Zie alle details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', 'Baan voorkeur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Laten we uw servicepagina instellen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Diensten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'Services kunnen niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'Services zijn opgeslagen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Aangeboden diensten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'Ongeldig identiteitsbewijs');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'Diensten zijn bijgewerkt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', 'Bewerk jobvoorkeuren');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', 'Werkvoorkeuren zijn bewerkt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Laad meer diensten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Tijper');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'Kies wat je mecenassen aanbiedt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Voeg tier toe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'Titel titel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Tierprijs');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Tier afbeelding');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Tierbeschrijving');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Voordelen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Chat zonder audio- en videogesprek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Chatten met audio-oproep en zonder videogesprek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Chatten zonder audio-oproep en met videogesprek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Chat met audio- en videogesprek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Chatten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Livestream');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'Prijs kan niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'Voordelen kunnen niet leeg zijn');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'Selecteer het chattype');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Tier is succesvol toegevoegd');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Bewerk tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Tier succesvol bijgewerkt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'Verwijder je tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', 'Weet je zeker dat je deze tier wilt verwijderen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'Patroon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'Patronen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Diensten die je misschien leuk vindt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', 'Open voor werkpalen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'Afrikaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'Albanees');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amharisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', 'Arabisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'Aragonese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'Armeens');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'Asturisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'Azerbeidzjani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'baskisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Wit-Russisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'Bengaals');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'Bosnisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'Breton');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'Bulgaars');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'Catalaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Centraal koerdisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', 'Chinese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Corsicaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'Kroatisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', 'Tsjechisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'Deens');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'Nederlands');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'Engels');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'Esperanto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'Estlands');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Farroom');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Filipijns');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'Fins');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'Frans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'Galicisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'Georgisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'Duits');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'Grieks');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guarani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'Hawaiiaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', 'Hebreeuws');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'Hindi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'Hongaars');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', 'IJslands');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'Indonesisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', 'Iers');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', 'Italiaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'Japans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Kazachs');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'Koreaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'Koerdisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'Kirgizi??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'Latijns');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'Letland');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'Litouws');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'Macedonisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'Maleis-');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'Maltees');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'Mongools');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'Nepali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'Noors');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Norwegian Bokm??l');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Noors Nynorsk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitaan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'ORIYA');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'Pashto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'Perzisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'Pools');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'Portugees');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'Punjabi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'Quechua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'Roemeense');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romansh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'Russisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', 'Schotse Gaelic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 'Servisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'Serbo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shona');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'Sinhala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'Slowaaks');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'Sloveens');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'Somalisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'Zuidelijke sotho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', 'Spaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'Swahili');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', 'Zweeds');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tadjik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 'Tamil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'Tatar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'Thais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrinya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tongan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'Turks');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'Turkmen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'Oekra??ens');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'Urdu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uyghur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', 'Oezbeek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'Vietnamees');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'Waals');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'Welsh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Westerse Fries');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'Jiddisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'Zulu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'Geen beschikbare gegevens om te laten zien.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'Mijn portemonnee');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'Je hebt een product gekocht');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Verkoop Producten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'Gehele site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'Je was verbannen voor het schenden van onze gebruiksvoorwaarden. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Oeps, je bent verbannen van {site_name}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'Gelieve {CONTACT_US} voor meer informatie.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'Bevestig PDF-bestand');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Certificaat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', 'Werk je momenteel?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'Nee, ik ben op zoek om te werken');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'Ja, ik ben op zoek naar werknemers');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Producten te koop');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'Je kunt je meldingen niet bekijken omdat je bent verbannen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'Je kunt je berichten niet bekijken omdat je bent verbannen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', 'Je kunt je verzoeken niet bekijken omdat je bent verbannen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'Opname');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'Geld is succesvol ontvangen van');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<H4> 1 - Schrijf hier uw gebruiksvoorwaarden. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<H4> 1 1 1 Schrijf over uw website hier. </ H4> Lorem Ipsum Dolor Sit amet, CONTECTOTURE ADIPISICING ELIT, SED DO EIANMOD TRORT INCIDIDUNT UT LABORE et Dolore Magna Aliqua. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<H4> 1 - Schrijf hier uw gebruiksvoorwaarden. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', 'Beoordeeld op uw product');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', 'Productaankoop');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', 'Productverkoop');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'Beschrijf hier uw beoordeling ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'gerelateerde producten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', 'Weet je zeker dat je wilt verwijderen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', 'Weet je zeker dat je deze services wilt verwijderen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', 'Zoeken, vinden en toepassen op vacatures bij');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', 'Maak verbinding met vrienden!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', 'Log in op uw {site_name}-account en maak verbinding met je vrienden!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'Onthoud dit apparaat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', 'Maak uw {site_name}-account aan!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'Just Pro-gebruikers kunnen uploaden upgrade naar Pro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'Uw post-inhoud kan niet leeg zijn.');
        } else if ($value == 'french') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'Vous devez ajouter un texte ou une image');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'Ajouter au panier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Supprimer du panier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'Payer par portefeuille');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'Vous n\'avez pas assez d\'??quilibre pour acheter, veuillez recharger votre portefeuille.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'Vous ??tes sur le point de passer ?? un membre professionnel.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'Vous ??tes sur le point de faire un don.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'Montant est requis');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'Le financement n\'est pas trouv??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', 'Paiement effectu?? avec succ??s, merci!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', 'Acheter maintenant');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Total des unit??s d\'article');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', 'Les unit??s d\'article sont n??cessaires');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', 'Actuellement indisponible.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', 'V??rifier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'Aucun ??l??ment trouv??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Le total');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'Mes adresses');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'Ajouter de nouveau');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Ajouter une nouvelle adresse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Votre adresse a ??t?? ajout??e avec succ??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'Supprimer votre adresse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', '??tes-vous s??r de vouloir supprimer cette adresse?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'Modifier l\'adresse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Votre adresse a ??t?? modifi??e avec succ??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'S\'il vous pla??t ajouter une nouvelle adresse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'Veuillez s??lectionner une adresse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', 'Alerte de paiement');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', 'Vous ??tes sur le point d\'acheter les articles, voulez-vous continuer?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Panier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', 'Articles');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'Retour au magasin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Certains produits sont en rupture de stock.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'L\'adresse ne peut pas ??tre vide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Adresse introuvable');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'Le panier est vide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Votre commande a ??t?? plac??e avec succ??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'Achet??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'Aucun article achet?? trouv??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Commander');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'T??l??charger la facture');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'ID est requis');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'Vous n\'avez pas encore achet??.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Commande introuvable');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'D??tails de la commande');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Ecrire une critique');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Demande ?? ??tre rembours??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'D??tails de suivi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Adresse de livraison');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'Si l\'??tat de la commande n\'??tait pas d??fini sur livr?? dans les 60 jours ?? compter de la date de la commande, il sera automatiquement envoy?? ?? \"livr??\".');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'Si la commande n\'??tait pas r??ellement livr??e, l\'acheteur peut demander un remboursement.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Mis');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', 'Paiements');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'Total');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Facture de vente');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Nom du Vendeur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Vendeur e-mail');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Facture ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', 'D??tails de paiement');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Total d??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'Nom de banque');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Facture d\'achat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Article');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Ordres');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'Aucune commande trouv??e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', 'Des produits');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Quantit??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', 'Annul??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Accept??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Emball??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Exp??di??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'Commission');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Prix ??????final');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'Num??ro de suivi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Lien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', 'Les informations de suivi ont ??t?? sauvegard??es avec succ??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', 'L\'URL de suivi ne peut pas ??tre vide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', 'Le num??ro de suivi ne peut pas ??tre vide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'S\'il vous pla??t entrer une URL valide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'URL du site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Livr??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'S\'il vous pla??t expliquer la raison');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', 'Votre demande est ?? l\'??tude, nous vous contacterons une fois termin??.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'Passer en revue');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'Soumettre');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', 'Examiner le contenu est requis.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'la note ne peut pas ??tre vide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', 'Votre avis a ??t?? soumis.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'Le statut de commande a ??t?? chang??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'Les nouvelles commandes ont ??t?? plac??es');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'Info de suivi ajout??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', 'Votre produit a ??t?? approuv??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', 'Votre produit est actuellement ?? l\'??tude.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Interroger');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', '??crivez une r??ponse et appuyez sur Entr??e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'R??pondre ?? r??pondre');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'r??pondu ?? votre question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'r??pondit ?? votre r??ponse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', 'aim?? votre question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', 'aim?? votre r??ponse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'vous a mentionn?? sur une r??ponse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'vous a mentionn?? sur une question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Achat v??rifi??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'Aucun commentaire trouv??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'demander anonymement');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Demander ?? un ami');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Rechercher des amis');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'Quoi, quand, pourquoi ... demander');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'Question est requise.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'S\'il vous pla??t s??lectionner qui vous voulez demander');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'vous a pos?? une question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Questions de tendance');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', 'Les gens ont aim?? cette question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', 'Les gens ont aim?? cette r??ponse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'Aucune r??ponse ?? montrer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', 'Rechercher des personnes et #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Des questions');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Tweets de tendance');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', 'Les gens ont aim?? ce tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'aim?? ton tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'Veuillez s??lectionner un fichier ?? t??l??charger');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'D??verrouillez ce contenu en devenant un client');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', 'Adh??rer maintenant');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Prix ??????d\'adh??sion de Patreon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'De l\'exp??rience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'Ajouter une nouvelle exp??rience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', 'Nom de la compagnie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', 'Type d\'emploi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', '?? temps plein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', '?? temps partiel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Travailleur ind??pendant');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Free-lance');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'Contracter');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'Stage');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', 'Apprentissage');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'Saisonnier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Industrie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'S\'il vous pla??t entrer un titre');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'S\'il vous pla??t entrer un nom d\'entreprise');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'S\'il vous pla??t entrer un type d\'emploi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'S\'il vous pla??t entrer un emplacement');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'S\'il vous pla??t entrer une date de d??but');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'S\'il vous pla??t entrer dans une industrie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'S\'il vous pla??t entrer une description');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'Veuillez choisir une date correcte.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Exp??rience cr????e avec succ??s.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'Veuillez entrer un lien valide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'Supprimer votre exp??rience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', '??tes-vous s??r de vouloir supprimer cette exp??rience?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'Modifier l\'exp??rience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'Vous n\'??tes pas le propri??taire, vous pouvez appliquer cette action.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Exp??rience mise ?? jour avec succ??s.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Certifications');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Licences et certificats');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'Ajouter un nouveau certificat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Organisation ??mettrice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'ID de cr??ditif');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'URL de Credential');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'S\'il vous pla??t entrer une organisation ??mettrice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'Date d\'??mission');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Date d\'expiration');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'Veuillez entrer la date d\'??mission.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'S\'il vous pla??t entrer un nom');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Votre certificat a ??t?? cr????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'Supprimer votre certificat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', '??tes-vous s??r de vouloir supprimer ce certificat?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', '??dition de certificat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Votre certificat a ??t?? mis ?? jour.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Projets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'Ajouter un nouveau projet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Nom du projet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', 'Associ?? ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'URL du projet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Votre projet a ??t?? ajout??.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'Supprimer votre projet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', '??tes-vous s??r de vouloir supprimer ce projet?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Modifier le projet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Votre projet a ??t?? mis ?? jour.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'Comp??tences');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'Langues');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'Ouvert ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Trouver un nouvel emploi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Fournissant des services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', 'Embauche');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', 'Ajouter des pr??f??rences d\'emploi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Dites-nous quel genre de travail vous ??tes ouvert ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', 'Lieux de travail');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', 'Titres d\'emploi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'Sur site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'Hybride');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', '?? distance');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', 'Types d\'emplois');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Temporaire');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', 'Lieu de travail');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', 'Le titre du poste ne peut pas ??tre vide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', 'L\'emplacement du travail ne peut pas ??tre vide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'Veuillez s??lectionner un lieu de travail');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'Veuillez s??lectionner un type d\'emploi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', 'Les pr??f??rences d\'emploi ont ??t?? mises ?? jour.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', 'Ouvert au travail');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'Voir tous les d??tails');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', 'Pr??f??rences d\'emploi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Configurons votre page Services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Prestations de service');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'Les services ne peuvent pas ??tre vides');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'Les services ont ??t?? enregistr??s.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Services fournis');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'ID invalide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'Les services ont ??t?? mis ?? jour.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', 'Modifier les pr??f??rences d\'emploi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', 'Les pr??f??rences d\'emploi ont ??t?? modifi??es.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Charger plus de services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Niveaux');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'Choisissez quoi offrir vos clients');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Ajouter un niveau');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'Titre de niveau');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Prix ??????de palier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Image de niveau');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Description de niveau');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Avantages');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Chatter sans appel audio et vid??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Chattez avec appel audio et sans appel vid??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Chattez sans appel audio et avec appel vid??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Discutez avec un appel audio et vid??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Discuter');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Direct');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'Le prix ne peut pas ??tre vide');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'Les avantages ne peuvent pas ??tre vides');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'Veuillez s??lectionner le type de discussion');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Niveau ajout?? avec succ??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Modifier le niveau');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Niveau mis ?? jour avec succ??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'Supprimer votre niveau');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', '??tes-vous s??r de vouloir supprimer ce niveau?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'm??c??ne');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'Patrons');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Services que vous pouvez aimer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', 'Ouvert aux postes de travail');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'afrikaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'albanais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amharique');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', 'arabe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'Aragonais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'arm??nien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'Asturian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'azerba??djanais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'basque');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Bi??lorusse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'bengali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'Bosniaque');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'Breton');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'bulgare');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'catalan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Kurde central');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', 'chinois');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Corse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'croate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', 'tch??que');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'danois');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'n??erlandais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'Anglais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'esp??ranto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'estonien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Farsee');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Philippin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'finlandais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'fran??ais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'Galicien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'g??orgien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'allemand');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'grec');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guarani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'hawa??en');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', 'h??breu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'hindi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'hongrois');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', 'islandais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'indon??sien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', 'irlandais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', 'italien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'Japonais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Kazakh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'cor??en');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'kurde');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'Kirghize');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'Latin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'letton');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'lituanien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'Mac??donien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'malais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'maltais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'mongol');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'n??palais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'norv??gien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Norv??gien bokm??l');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Norv??gien Nynorsk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'Oriya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'Pashto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'persan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'polonais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'Portugais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'Punjabi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'Quechua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'roumain');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romansh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'russe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', 'Ga??lique ??cossais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 'serbe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'Serbo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shona');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'Sinhala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'slovaque');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'slov??ne');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'somali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'Sotho du sud');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', 'Espagnol');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'Swahili');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', 'su??dois');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tajik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 'Tamil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'tatar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'tha??landais');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrinya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tongan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'turc');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'Turkm??ne');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'ukrainien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'Ourdou');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uyghur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', 'Uzbek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'vietnamien');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'Wallon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'gallois');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Frison occidental');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'yiddish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'zoulou');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'Aucune donn??e disponible ?? afficher.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'Mon portefeuille');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'Vous avez achet?? un produit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Vente produits');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'Site entier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'Vous avez ??t?? interdit de violer nos conditions d\'utilisation. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Oups, vous avez ??t?? banni de {Nom de site}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'S\'il vous pla??t {contact_us} pour plus de d??tails.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'Joindre un fichier PDF');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Certificat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', 'Travaillez-vous actuellement?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'Non je cherche ?? travailler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'Oui je cherche des employ??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Produits ?? vendre');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'Vous ne pouvez pas voir vos notifications parce que vous avez ??t?? banni');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'Vous ne pouvez pas voir vos messages parce que vous avez ??t?? interdit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', 'Vous ne pouvez pas voir vos demandes parce que vous avez ??t?? interdit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'Retrait');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'L\'argent a ??t?? re??u avec succ??s de');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- ??crivez vos conditions d\'utilisation ici. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<H4> 1- ??crivez sur votre site web ici. </ H4> Lorem Ipsum Dolor Sit Amet, Consectetur Adipisuring Elit, SED Do Eiusmod Tempor Incididunt UT Labore et Dolore Magna Aliqua. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<H4> 1- ??crivez vos conditions d\'utilisation ici. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', 'examin?? votre produit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', 'Achat de produit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', 'Vente de produits');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'D??crivez votre avis ici ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'Produits connexes');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', 'Etes-vous s??r que vous voulez supprimer?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', '??tes-vous s??r de vouloir supprimer ces services?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', 'Rechercher, trouver et postuler aux opportunit??s d\'emploi ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', 'Connectez-vous avec des amis!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', 'Connectez-vous ?? votre compte {Site_Name} et connectez-vous avec vos amis!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'Rappelez-vous cet appareil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', 'Cr??ez votre compte {Site_Name}!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'Just Pro utilisateurs peuvent t??l??charger s\'il vous pla??t mettre ?? niveau vers Pro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'Votre contenu post ne peut pas ??tre vide.');
        } else if ($value == 'german') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'Sie m??ssen einen Text oder ein Bild hinzuf??gen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'In den Warenkorb legen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Aus dem Warenkorb entfernen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'Bezahlen von Brieftasche');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'Sie haben nicht genug Gleichgewicht zum Kauf, bitte tippen Sie bitte Ihre Brieftasche auf.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'Sie d??rfen gerade auf ein Pro-Mitglied ein Upgrade eingehen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'Du bist dabei, zu spenden.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'Betrag ist erforderlich');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'Die Finanzierung wird nicht gefunden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', 'Zahlung erfolgreich gemacht, danke!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', 'Kaufe jetzt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Gesamtst??ckeinheiten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', 'Artikeleinheiten sind erforderlich');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', 'Momentan nicht verf??gbar.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', 'Kasse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'Keine Elemente gefunden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Gesamt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'Meine Adressen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'Neue hinzuf??gen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Neue Adresse hinzuf??gen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Ihre Adresse wurde erfolgreich hinzugef??gt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'L??schen Sie Ihre Adresse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', 'M??chten Sie diese Adresse sicher, dass Sie diese Adresse l??schen m??chten?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'Adresse bearbeiten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Ihre Adresse wurde erfolgreich bearbeitet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'Bitte f??gen Sie eine neue Adresse hinzu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'Bitte w??hlen Sie eine Adresse aus');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', 'Zahlungsalarm');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', 'Sie k??nnen die Artikel kaufen, m??chten Sie fortfahren?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Einkaufswagen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', 'Produkte');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'Zur??ck zum Laden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Einige Produkte sind nicht auf Lager.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'Adresse kann nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Adresse nicht gefunden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'Einkaufswagen ist leer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Ihre Bestellung wurde erfolgreich platziert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'Gekauft');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'Es wurden keine gekauften Elemente gefunden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Befehl');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'Download Rechnung');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'ID ist erforderlich');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'Sie haben noch nicht gekauft.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Bestellen nicht gefunden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'Bestelldetails');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Bewertung schreiben');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Eine R??ckerstattung anfordern');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'Verfolgungsdetails');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Lieferadresse');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'Wenn der Bestellstatus nicht innerhalb von 60 Tagen ab dem Bestelldatum angeliefert wurde, wird es automatisch an \"geliefert\" gesendet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'Wenn die Bestellung nicht tats??chlich geliefert wurde, kann der K??ufer eine R??ckerstattung anfordern.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Platziert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', 'Zahlungen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'Zwischensumme');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Verkauf Rechnung.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Name des Verk??ufers');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Verk??ufer-E-Mail.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Rechnung an');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', 'Zahlungsdetails');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Insgesamt f??llig.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'Bank Name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Rechnung');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Artikel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Auftr??ge');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'Keine Bestellungen gefunden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', 'Produkte');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Attiert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', 'Abgesagt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Akzeptiert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Verpackt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Geliefert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'Kommission');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Endg??ltiger Preis');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'Auftragsnummer, Frachtnummer, Sendungscode');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Verkn??pfung');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', 'Tracking-Info wurde erfolgreich gespeichert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', 'Tracking-URL kann nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', 'Die Tracking-Nummer kann nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'Bitte geben Sie eine g??ltige URL ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'Seiten-URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Geliefert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'Bitte erkl??re den Grund');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', 'Ihre Anfrage ist ??berpr??ft, wir kontaktieren Sie einmal mit Ihnen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'Rezension');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'einreichen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', 'Der ??berpr??fen des Inhalts ist erforderlich.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'Bewertung kann nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', 'Ihre ??berpr??fung wurde eingereicht.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'Der Bestellstatus wurde ge??ndert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'Neue Bestellungen wurden platziert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'Tracking-Info hinzugef??gt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', 'Ihr Produkt wurde genehmigt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', 'Ihr Produkt wird derzeit ??berpr??ft.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Fragen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', 'Schreiben Sie eine Antwort und dr??cken Sie die Eingabetaste');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'Antwort auf Antwort');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'Antwortete deine Frage.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'antwortete auf deine Antwort');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', 'Mochte deine Frage.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', 'mochte deine Antwort');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'erw??hnte Sie auf einer Antwort');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'erw??hnte Sie eine Frage');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Gepr??fter Kauf.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'Keine Bewertungen gefunden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'Anonym Fragen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Frag einen Freund');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Suche nach Freunden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'Was, wann, warum ... fragen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'Frage ist erforderlich.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'Bitte w??hlen Sie aus, wer Sie fragen m??chten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'fragte dir eine Frage');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Fragen zum Trend');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', 'Die Leute haben diese Frage gefallen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', 'Die Leute haben diese Antwort mochten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'Keine Antworten zu zeigen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', 'Suche nach Personen und #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Fragen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Trending-Tweets.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', 'Die Leute haben diesen Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'mochte deinen Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'Bitte w??hlen Sie eine Datei zum Hochladen aus');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'Entsperren Sie diesen Inhalt, indem Sie ein Patron werden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', 'Jetzt beitreten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Patreon-Mitgliedschaftspreis.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'Erfahrung');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'Neue Erfahrung hinzuf??gen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', 'Name der Firma');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', 'Besch??ftigungsverh??ltnis');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', 'Vollzeit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', 'Teilzeit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Selbstst??ndiger');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Freiberuflich');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'Vertrag');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'Praktikum');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', 'Ausbildung');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'Saisonal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Industrie');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'Bitte geben Sie einen Titel ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'Bitte geben Sie einen Firmennamen ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'Bitte geben Sie einen Besch??ftigungsart ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'Bitte geben Sie einen Ort ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'Bitte geben Sie ein Startdatum ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'Bitte geben Sie eine Branche ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'Bitte geben Sie eine Beschreibung ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'Bitte w??hlen Sie ein korrektes Datum.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Erfahrung erfolgreich erstellt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'Bitte geben Sie einen g??ltigen Link ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'L??schen Sie Ihre Erfahrungen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', 'M??chten Sie diese Erfahrung sicher, dass Sie diese Erfahrung l??schen m??chten?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'Erfahrung bearbeiten.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'Sie sind nicht der Besitzer, Sie k??nnen diese Aktion anwenden.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Erfahrung erfolgreich aktualisiert.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Zertifizierungen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Lizenzen & Zertifikate.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'Neues Zertifikat hinzuf??gen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Ausstellende Organisation');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'Anmeldeinformations-ID.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'Anmeldeinformations-URL.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'Bitte geben Sie eine ausstellende Organisation ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'Ausgabedatum');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Ablaufdatum');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'Bitte geben Sie das ausstellende Datum ein.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'Bitte geben Sie einen Namen ein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Ihr Zertifikat wurde erstellt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'L??schen Sie Ihr Zertifikat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', 'M??chten Sie dieses Zertifikat sicher l??schen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', 'Zertifikat bearbeiten.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Ihr Zertifikat wurde aktualisiert.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Projekte');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'Neues Projekt hinzuf??gen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Projektname');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', 'Verkn??pft mit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'Projekt-URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Ihr Projekt wurde hinzugef??gt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'L??schen Sie Ihr Projekt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', 'M??chten Sie dieses Projekt sicher l??schen?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Projekt bearbeiten.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Ihr Projekt wurde aktualisiert.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'F??higkeiten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'Sprachen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'Ge??ffnet f??r');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Einen neuen Job finden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Erbringung von Dienstleistungen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', 'Einstellung');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', 'Jobeinstellungen hinzuf??gen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Sagen Sie uns, welche Art von Arbeit Sie offen sind');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', 'Arbeitspl??tze.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', 'Berufsbezeichnungen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'Vor Ort');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'Hybride');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', 'Fernbedienung');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', 'Arbeitstypen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Vor??bergehend');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', 'Arbeitsplatz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', 'Die Arbeitstitel kann nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', 'Der Jobstandort kann nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'Bitte w??hlen Sie einen Arbeitsplatz aus');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'Bitte w??hlen Sie einen Jobtyp aus');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', 'Die Jobeinstellungen wurden aktualisiert.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', 'Offen f??r die Arbeit.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'Alle Details anzeigen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', 'Stellenpr??ferenzen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Lassen Sie uns Ihre Service-Seite einrichten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Dienstleistungen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'Dienste k??nnen nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'Dienstleistungen wurden gespeichert.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Dienstleistungen zur Verf??gung gestellt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'Ung??ltige ID');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'Dienstleistungen wurden aktualisiert.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', 'Jobeinstellungen bearbeiten.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', 'Stellenvoreinstellungen wurden bearbeitet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Mehr Dienstleistungen laden.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Reihen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'W??hlen Sie aus, was Sie Ihren G??sten anbieten sollen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Tier hinzuf??gen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'Titel Titel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Tierpreis');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Tier-Image');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Tierbeschreibung.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Leistungen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Chatten Sie ohne Audio- und Videoanruf');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Chatten Sie mit Audio-Anruf und ohne Videoanruf');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Chat ohne Audioanruf und mit Videoanruf');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Chat mit Audio- und Videoanruf');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Plaudern');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Live??bertragung');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'Der Preis kann nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'Vorteile k??nnen nicht leer sein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'Bitte w??hlen Sie den Chat-Typ aus');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Tier erfolgreich hinzugef??gt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Tier bearbeiten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Tier erfolgreich aktualisiert.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'L??schen Sie Ihren Tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', 'Bist du sicher, dass du diesen Tier l??schen willst?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'Patron');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'G??nner');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Dienstleistungen, die Sie m??gen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', 'Offen f??r Arbeitsbeitr??ge');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'Afrikaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'albanisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amharisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', 'Arabisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'Aragonesen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'Armenisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'Asturianisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'Aserbaidschani.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'baskisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Belarussisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'Bengali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'bosnisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'Bretonisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'bulgarisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'katalanisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Zentralkurdish.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', 'Chinesisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Korsikan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'kroatisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', 'Tschechisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'd??nisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'Niederl??ndisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'Englisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'Esperanto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'estnisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Faroese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Philippinisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'finnisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'Franz??sisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'galizisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'georgisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'Deutsch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'griechisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guarani.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'hawaiisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', 'hebr??isch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'Hindi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'ungarisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', 'isl??ndisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'Indonesisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', 'irisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', 'Italienisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'japanisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Kasakh.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'Koreanisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'kurdisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'Kirgisisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'Latein');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'lettisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'litauisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'mazedonisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'malaiisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'maltesisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'mongolisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'Nepali.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'norwegisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Norwegisch Bokm??l.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Norwegisches Nynorsk.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Okzitanisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'Oriya.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'Pashto.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'persisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'Polieren');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'Portugiesisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'Punjabi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'Quechua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'rum??nisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romansh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'Russisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', 'schottisch G??lisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 'serbisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'Serbo.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shona.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'Sinhala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'slowakisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'Slowenisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'somali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'S??dlich sotho.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', 'Spanisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sonnendanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'Swahili');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', 'Schwedisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tadschik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 'Tamilisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'Tatar.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'Thail??ndisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrinya.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tanganer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'T??rkisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'Turkmen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'ukrainisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'Urdu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uyghur.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', 'Usbekisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'Vietnamesisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'wallonisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'Walisisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Westernfriesian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'Jiddisch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'Zulu-');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'Keine verf??gbaren Daten zum Anzeigen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'Mein Geldbeutel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'Sie haben ein Produkt gekauft');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Verkaufsprodukte');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'Ganze Seite');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'Sie wurden verboten, um unsere Nutzungsbedingungen zu verletzen. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Oops, du wurdest von {site_name} gesperrt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'Bitte {contact_us} f??r weitere Details.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'PDF-Datei anh??ngen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Zertifikat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', 'arbeitest du gerade?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'Nein, ich suche ich');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'Ja, ich suche Mitarbeiter');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Produkte zum Verkauf.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'Sie k??nnen Ihre Benachrichtigungen nicht anzeigen, weil Sie gesperrt wurden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'Sie k??nnen Ihre Nachrichten nicht anzeigen, da Sie gesperrt wurden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', 'Sie k??nnen Ihre Anfragen nicht anzeigen, weil Sie gesperrt wurden');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'R??ckzug');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'Geld wurde erfolgreich von erhalten');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- Schreiben Sie hier Ihre Nutzungsbedingungen. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<H4> 1- Schreiben Sie hier ??ber Ihre Website. </ H4> Lorem Ipsum Dolor Sit AMET, Konsektor-Adipialisierung Elit, SED do EiusMod Tencipe Incididunts Ut Labore et dolore Magna Aliqua. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<H4> 1- Schreiben Sie hier Ihre Nutzungsbedingungen. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', '??berpr??fte dein Produkt.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', 'Produktkauf.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', 'Produktverkauf.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'Beschreiben Sie Ihre Bewertung hier ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'Verwandte Produkte');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', 'Sind Sie sicher, dass Sie l??schen m??chten?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', 'Sind Sie sicher, dass Sie diese Dienste l??schen m??chten?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', 'Suchen, finden und anwenden Sie sich f??r Stellenangebote an');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', 'Verbinden Sie sich mit Freunden!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', 'Melden Sie sich in Ihr {site_name} Konto an und verbinden Sie sich mit Ihren Freunden!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'erinnern Sie sich an dieses Ger??t');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', 'Erstellen Sie Ihr {site_name} Konto!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'Nur Pro-Benutzer k??nnen hochladen, bitte aktualisieren auf pro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'Ihr Postinhalt kann nicht leer sein.');
        } else if ($value == 'italian') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'Devi aggiungere un testo o un\'immagine');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'Aggiungi al carrello');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Rimuovi dal carrello');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'Pagare con il portafoglio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'Non hai abbastanza equilibrio da acquistare, per favore rabboccare il tuo portafoglio.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'Stai per eseguire l\'aggiornamento a un membro professionale.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'Stai per donare.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'L\'importo ?? richiesto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'Il finanziamento non ?? stato trovato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', 'Pagamento fatto con successo, grazie!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', 'Acquista ora');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Unit?? di articoli totali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', 'Le unit?? degli articoli sono richieste');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', 'Attualmente non disponibile.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', 'Guardare');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'Nessun articolo trovato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Totale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'I miei indirizzi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'Aggiungere nuova');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Aggiungi un nuovo indirizzo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Il tuo indirizzo ?? stato aggiunto con successo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'Elimina il tuo indirizzo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', 'Sei sicuro di voler eliminare questo indirizzo?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'Modifica indirizzo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Il tuo indirizzo ?? stato modificato con successo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'Si prega di aggiungere un nuovo indirizzo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'Si prega di selezionare un indirizzo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', 'Avviso di pagamento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', 'Stai per acquistare gli articoli, vuoi procedere?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Carrello della spesa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', 'Elementi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'Torna a Shop.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Alcuni prodotti sono esauriti.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'L\'indirizzo non pu?? essere vuoto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Indirizzo non trovato.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'Il carrello ?? vuoto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Il tuo ordine ?? stato posizionato con successo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'Acquistato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'Nessun articolo acquistato trovato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Ordine');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'Scarica Fattura');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'L\'ID ?? richiesto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'Non hai ancora acquistato.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Ordine non trovato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'Dettagli ordine');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Scrivere una recensione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Richiedere un rimborso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'Tracciamento dei dettagli');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Indirizzo di consegna');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'Se lo stato dell\'ordine non ?? stato impostato su Fornito entro 60 giorni dalla data dell\'ordine, verr?? automaticamente inviato a \"consegnato\".');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'Se l\'ordine non ?? stato effettivamente consegnato, l\'acquirente pu?? richiedere un rimborso.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Posto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', 'Pagamenti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'totale parziale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Fattura di vendita');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Nome del venditore');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Email del venditore');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Fattura');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', 'Dettagli di pagamento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Totale dovuto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'nome della banca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Fattura');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Elemento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Ordini');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'Nessun ordine trovato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', 'Prodotti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Qty.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', 'Annullato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Accettato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Confezionato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Spedito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'Commissione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Prezzo finale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'Numero di identificazione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Collegamento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', 'Le informazioni di tracciamento sono state salvate con successo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', 'L\'URL di tracciamento non pu?? essere vuoto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', 'Il numero di tracciamento non pu?? essere vuoto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'Per favore, inserisci un URL valido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'Indirizzo del sito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Consegnato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'Si prega di spiegare la ragione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', 'La tua richiesta ?? in fase di revisione, ti contattiamo una volta.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'Revisione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'Invia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', 'Il contenuto della revisione ?? richiesto.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'La valutazione non pu?? essere vuota');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', 'La tua recensione ?? stata presentata.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'Lo stato dell\'ordine ?? stato modificato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'I nuovi ordini sono stati collocati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'Aggiunto informazioni di monitoraggio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', 'Il tuo prodotto ?? stato approvato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', 'Il tuo prodotto ?? attualmente in esame.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'Tweet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Chiedere');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', 'Scrivi una risposta e premi Invio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'Rispondi a Risposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'ha risposto alla tua domanda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'ha risposto alla tua risposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', '?? piaciuta la tua domanda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', '?? piaciuta la tua risposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'ti ho detto su una risposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'ti ha detto su una domanda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Acquisto verificato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'Nessuna recensione trovata');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'Chiedere anonimamente');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Chiedi a un amico');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Cerca amici.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'Cosa, quando, perch?? ... chiedi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'La domanda ?? richiesta.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'Si prega di selezionare chi vuoi chiedere');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'ti ha fatto una domanda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Domande di tendenza');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', 'Alla gente ?? piaciuta questa domanda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', 'Alla gente ?? piaciuta questa risposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'Nessuna risposta da mostrare');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', 'Cerca persone e #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Domande');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweets.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Trending Tweet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', 'A gente ?? piaciuto questo tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'Mi ?? piaciuto il tuo Tweet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'Si prega di selezionare un file da caricare');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'Sblocca questo contenuto diventando un patrono');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', 'Iscriviti adesso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Prezzo di appartenenza Patreon.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'Esperienza');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'Aggiungi una nuova esperienza');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', 'Nome della ditta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', 'Tipo di impiego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', 'Tempo pieno');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', 'Part time');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Lavoratore autonomo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Libero professionista');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'Contrarre');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'tirocinio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', 'Apprendistato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'di stagione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Industria');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'Si prega di inserire un titolo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'Si prega di inserire un nome aziendale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'Si prega di inserire un tipo di occupazione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'Si prega di inserire una posizione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'Si prega di inserire una data di inizio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'Per favore inserisci un settore');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'Si prega di inserire una descrizione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'Si prega di scegliere una data corretta.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Esperienza creata con successo.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'Si prega di inserire un link valido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'Elimina la tua esperienza');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', 'Sei sicuro di voler cancellare questa esperienza?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'Edit Experience.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'Non sei il proprietario, puoi applicare questa azione.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Esperienza aggiornata con successo.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Certificazioni');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Licenze e certificati.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'Aggiungi un nuovo certificato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Organizzazione di emissione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'ID Credenziali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'URL delle credenziali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'Si prega di inserire un\'organizzazione di emissione');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'Data di rilascio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Data di scadenza');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'Si prega di inserire la data di emissione.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'Si prega di inserire un nome');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Il tuo certificato ?? stato creato.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'Elimina il tuo certificato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', 'Sei sicuro di voler cancellare questo certificato?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', 'Modifica certificato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Il tuo certificato ?? stato aggiornato.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Progetti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'Aggiungi un nuovo progetto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Nome del progetto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', 'Associato a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'URL del progetto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Il tuo progetto ?? stato aggiunto.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'Elimina il tuo progetto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', 'Sei sicuro di voler cancellare questo progetto?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Modifica progetto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Il tuo progetto ?? stato aggiornato.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'Abilit??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'Le lingue');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'Aperto a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Trovare un nuovo lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Fornitura di servizi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', 'Assumere');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', 'Aggiungi preferenze di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Dicci che tipo di lavoro sei aperto a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', 'Ambienti di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', 'Titolo di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'Sul posto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'Ibrido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', 'A distanza');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', 'Tipi di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Temporaneo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', 'Luogo di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', 'Il titolo del lavoro non pu?? essere vuoto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', 'La posizione del lavoro non pu?? essere vuota');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'Si prega di selezionare un luogo di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'Si prega di selezionare un tipo di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', 'Le preferenze del lavoro sono state aggiornate.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', 'Aperto al lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'Vedi tutti i dettagli');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', 'Preferenze di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Configura la pagina dei servizi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Servizi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'I servizi non possono essere vuoti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'I servizi sono stati salvati.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Servizio fornito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'ID non valido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'I servizi sono stati aggiornati.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', 'Modifica le preferenze del lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', 'Le preferenze di lavoro sono state modificate.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Carica pi?? servizi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Livelli');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'Scegli cosa offrire ai tuoi clienti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Aggiungi Tier.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'Titolo di livello');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Prezzo di livello');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Immagine di livello');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Descrizione di livello');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Benefici');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Chat senza audio e videochiamata');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Chat con audio chiamata e senza videochiamata');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Chat senza chiamata audio e con videochiamata');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Chat con audio e videochiamata');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Chiacchierata');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Trasmissione in diretta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'Il prezzo non pu?? essere vuoto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'I vantaggi non possono essere vuoti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'Si prega di selezionare il tipo di chat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Tier ha aggiunto con successo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Modifica il livello');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Tier aggiornato con successo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'Elimina il tuo livello');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', 'Sei sicuro di voler cancellare questo livello?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'Patrono');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'Patroni');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Servizi che potrebbero piacere');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', 'Aperto ai posti di lavoro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'afrikaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'albanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amharic.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', 'Arabo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'aragonese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'armeno');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'Asturiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'Azerbaijani.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'Basco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Bielorusso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'bengalese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'Bosniaco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'bretone');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'bulgaro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'catalano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Kurdish centrale.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', 'Cinese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Corsican.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'croato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', 'ceco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'danese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'olandese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'inglese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'esperanto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'Estone');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Faroese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Filippino');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'finlandese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'francese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'galiziano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'georgiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'Tedesco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'greco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guarani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'hawaiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', 'ebraico');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'hindi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'ungherese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', 'islandese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'indonesiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', 'irlandesi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', 'italiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'giapponese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Kazako.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'coreano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'Kurdo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'Kirghiz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'latino');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'lettone');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'Lituano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'macedone');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'malese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'maltese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'mongolo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'Nepalese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'norvegese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Norwegian Bokm??l.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Norvegese Nynorsk.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'Oriya.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'Pashto.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'persiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'polacco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'portoghese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'Punjabi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'Quechua.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'rumeno');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romancio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'russo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', 'Gaelico Scozzese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 'serbo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'Serbo.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shona.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'Singala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'Slovacco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'sloveno');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'Somalo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'Sothern Sotho.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', 'spagnolo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanese.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'Swahili.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', 'svedese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tajik.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 'Tamil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'Tatar.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'tailandese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrenya.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tongan.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'Turco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'Turkmen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'ucraino');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'Urdu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uyghur.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', 'Uzbeko.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'vietnamita');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'Walloon.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'gallese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Frisiano occidentale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'yiddish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'Zuli.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'Nessun dato disponibile da mostrare.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'Il mio portafoglio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'Hai comprato un prodotto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Prodotti di vendita');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'Intero sito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'Sei stato bannato per aver violato i nostri termini di utilizzo. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Oops, sei stato bannato da {sito_name}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'Vi preghiamo di contattarci per maggiori dettagli.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'Allega il file PDF.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Certificato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', 'Stai lavorando attualmente?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'No, sto cercando di lavorare');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'S??, sto cercando dipendenti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Prodotti in vendita.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'Non puoi vedere le tue notifiche perch?? sei stato bannato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'Non puoi visualizzare i tuoi messaggi perch?? sei stato bannato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', 'Non puoi visualizzare le tue richieste perch?? sei stato bannato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'Ritiro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'Il denaro ?? stato ricevuto con successo da');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<h4> 1- Scrivi i tuoi termini di utilizzo qui. </ h4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<H4> 1- Scrivi del tuo sito web qui. </ h4> Lorem Ipsum dolor sit Amet, Consectotur addipisicicing Elit, Sed do Eiusmod Timpor Incididunt Ut Labore et dolore Magna Aliqua. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<h4> 1- Scrivi i tuoi termini di utilizzo qui. </ h4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', 'Recensito il tuo prodotto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', 'Acquisto del prodotto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', 'Vendita del prodotto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'Descrivi la tua recensione qui ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'prodotti correlati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', 'Sei sicuro di voler eliminare?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', 'Sei sicuro di voler cancellare questi servizi?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', 'Cerca, trova e applica alle opportunit?? di lavoro a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', 'Connettiti con gli amici!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', 'Accedi al tuo account {sito_name} e connettiti con i tuoi amici!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'Ricorda questo dispositivo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', 'Crea il tuo account {sito_name}!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'Solo gli utenti PRO possono caricare aggiornare a Pro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'Il tuo contenuto del post non pu?? essere vuoto.');
        } else if ($value == 'portuguese') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'Voc?? deve adicionar um texto ou imagem');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'Adicionar ao carrinho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Retire do carrinho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'Pague pela Wallet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'Voc?? n??o tem equil??brio suficiente para comprar, por favor suba sua carteira.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'Voc?? est?? prestes a atualizar para um membro Pro.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'Voc?? est?? prestes a doar.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'Quantidade ?? necess??ria');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'Financiamento n??o ?? encontrado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', 'Pagamento feito com sucesso, obrigado!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', 'Compre');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Unidades totais de itens');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', 'Unidades de item s??o necess??rias');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', 'Atualmente indisponivel.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', 'Confira');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'Nenhum item encontrado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Total');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'Meus endere??os');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'Adicionar novo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Adicionar novo endere??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Seu endere??o foi adicionado com sucesso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'Exclua seu endere??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', 'Tem certeza de que deseja excluir este endere??o?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'Editar Endere??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Seu endere??o foi editado com sucesso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'Por favor, adicione um novo endere??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'Por favor, selecione um endere??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', 'Alerta de pagamento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', 'Voc?? est?? prestes a comprar os itens, deseja prosseguir?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Carrinho de compras');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', 'Itens');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'De volta ?? loja');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Alguns produtos est??o fora de estoque.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'Endere??o n??o pode estar vazio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Endere??o n??o encontrado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'carrinho esta vazio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Seu pedido foi feito com sucesso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'Comprado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'Nenhum item comprado encontrado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Pedido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'Baixe o Invoice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'ID ?? obrigat??rio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'Voc?? ainda n??o comprou.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Ordem n??o encontrada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'Detalhes do pedido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Escrever an??lise');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Pe??a um reembolso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'Detalhes de rastreamento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Endere??o de entrega');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'Se o status do pedido n??o foi definido como entregue no prazo de 60 dias a partir da data do pedido, ele ser?? automaticamente enviado para \"entregue\".');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'Se o pedido n??o foi realmente entregue, o comprador pode solicitar um reembolso.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Colocada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', 'Pagamentos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'Subtotal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Fatura de venda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Nome do Vendedor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Email do vendedor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Fatura para');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', 'Detalhes do pagamento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Total devido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'nome do banco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Fatura');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Item');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Pedidos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'Nenhuma encomenda encontrada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', 'Produtos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Qty.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', 'Cancelado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Aceitaram');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Embalado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Enviado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'Comiss??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Pre??o final');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'Numero de rastreio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Link');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', 'As informa????es de rastreamento foram salvas com sucesso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', 'O URL de rastreamento n??o pode estar vazio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', 'N??mero de rastreamento n??o pode estar vazio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'Por favor, insira um URL v??lido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'URL do site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Entregue');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'Por favor, explique o motivo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', 'Sua solicita????o est?? em revis??o, entramos em contato com voc?? uma vez.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'An??lise');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'Enviar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', 'O conte??do de revis??o ?? necess??rio.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'classifica????o n??o pode estar vazia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', 'Sua avalia????o foi enviada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'O status do pedido foi alterado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'Novas ordens foram colocadas');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'Acrescentou informa????es de rastreamento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', 'Seu produto foi aprovado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', 'Seu produto est?? atualmente em revis??o.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Perguntar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', 'Escreva uma resposta e pressione ENTER');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'Responder ?? resposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'Respondeu sua pergunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'respondeu ?? sua resposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', 'gostei da sua pergunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', 'gostei da sua resposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'mencionou voc?? em uma resposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'mencionou voc?? em uma pergunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Compra verificada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'Nenhum coment??rio encontrado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'Pergunte anonimamente');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Pergunte a um amigo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Procure por amigos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'O que, quando, por que ... pergunte');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'Pergunta ?? necess??ria.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'Por favor, selecione quem voc?? quer perguntar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'Perguntou uma pergunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Perguntas de tend??ncia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', 'As pessoas achou desta pergunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', 'As pessoas gostavam dessa resposta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'Sem respostas para mostrar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', 'Procurar pessoas e #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Perguntas');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweets.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Tend??ncias Tweets.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', 'As pessoas gostavam desse tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'gostou do seu tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'Por favor, selecione um arquivo para carregar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'Desbloquear este conte??do tornando-se um patrono');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', 'Entrar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Pre??o de associa????o de Patreon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'Experi??ncia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'Adicionar nova experi??ncia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', 'Nome da empresa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', 'Tipo de Emprego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', 'Tempo total');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', 'Meio per??odo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Trabalhadores por conta pr??pria');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Freelance');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'Contrato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'Est??gio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', 'Aprendizagem');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'Sazonal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Ind??stria');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'Por favor, insira um t??tulo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'Por favor, insira um nome da empresa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'Por favor, insira um tipo de emprego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'Por favor, digite um local');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'Por favor insira uma data de in??cio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'Por favor, insira uma ind??stria');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'Por favor, insira uma descri????o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'Por favor, escolha uma data correta.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Experi??ncia criada com sucesso.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'Por favor, insira um link v??lido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'Exclua sua experi??ncia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', 'Tem certeza de que deseja excluir essa experi??ncia?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'Editar experi??ncia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'Voc?? n??o ?? o propriet??rio, voc?? pode aplicar esta a????o.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Experi??ncia atualizada com sucesso.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Certifica????es.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Licen??as e certificados');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'Adicionar novo certificado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Organiza????o emissora');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'ID de credencial');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'URL de credenciais.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'Por favor, insira uma organiza????o emissora');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'Data de emiss??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Data de validade');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'Por favor, insira a data emissora.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'Por favor insira um nome');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Seu certificado foi criado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'Exclua seu certificado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', 'Tem certeza de que deseja excluir este certificado?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', 'Editar certificado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Seu certificado foi atualizado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Projetos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'Adicionar novo projeto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Nome do Projeto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', 'Associado com');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'URL do projeto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Seu projeto foi adicionado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'Exclua seu projeto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', 'Tem certeza de que deseja excluir este projeto?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Editar projeto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Seu projeto foi atualizado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'Habilidades');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'l??nguas');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'Aberto para');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Encontrando um novo emprego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Presta????o de servi??os');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', 'Contratando');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', 'Adicionar prefer??ncias de emprego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Diga-nos que tipo de trabalho voc?? est?? aberto para');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', 'Locais de trabalho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', 'T??tulos de trabalho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'No local');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'H??brido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', 'Controlo remoto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', 'Tipos de trabalho.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Tempor??rio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', 'Local de trabalho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', 'O cargo n??o pode estar vazio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', 'Localiza????o do trabalho n??o pode estar vazia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'Por favor, selecione um local de trabalho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'Por favor, selecione um tipo de trabalho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', 'Prefer??ncias de emprego foram atualizadas.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', 'Aberto para o trabalho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'Veja todos os detalhes');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', 'Prefer??ncias de trabalho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Vamos configurar sua p??gina de servi??os');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Servi??os');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'Os servi??os n??o podem ser vazios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'Servi??os foram salvos.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Servi??os prestados');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'ID Inv??lido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'Servi??os foram atualizados.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', 'Editar prefer??ncias de emprego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', 'Prefer??ncias de emprego foram editadas.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Carregue mais servi??os');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Camadas');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'Escolha o que oferecer seus patronos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Adicionar camada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'T??tulo do n??vel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Pre??o de camada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Imagem de camada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Descri????o da camada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Benef??cios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Bate-papo sem chamada de ??udio e v??deo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Bate-papo com chamada de ??udio e sem chamada de v??deo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Bate-papo sem chamada de ??udio e com chamada de v??deo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Bate-papo com chamada de ??udio e v??deo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Bate-papo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Transmiss??o ao vivo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'O pre??o n??o pode estar vazio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'Benef??cios n??o podem ser vazios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'Por favor, selecione o tipo de bate-papo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Camada adicionada com sucesso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Editar camada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Camada atualizada com sucesso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'Exclua sua camada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', 'Tem certeza de que deseja excluir esta camada?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'Patrono');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'Clientes');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Servi??os que voc?? pode gostar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', 'Aberto para postos de trabalho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'afrikaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'alban??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amharic.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', '??rabe');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'Aragon??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'Arm??nio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'Ast??ria');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'Azerbaijani.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'Basque.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Bielorrusso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'bengali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'B??snio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'Bret??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'b??lgaro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'catal??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Curdo central');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', 'chin??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Corsicana');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'croata');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', 'Checo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'dinamarqu??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'holand??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'ingl??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'esperanto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'estoniano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Faroese.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Filipino.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'finland??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'franc??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'Galego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'Georgiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'alem??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'grego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guarani.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'havaiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', 'hebraico');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'hindi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'h??ngaro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', 'island??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'indon??sio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interl??ngua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', 'irland??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', 'italiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'japon??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Cazaque');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'coreano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'curdo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'Quirguist??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'Latino');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'let??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'lituano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'Maced??nio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'malaio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'malt??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'mongol');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'Nepali.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'noruegu??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Bokm??l noruegu??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Nynorsk noruegu??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'Oriya.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'Pashto.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'persa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'polon??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'Portugu??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'Punjabi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'Quechua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'romena');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Roman??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'russo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', 'ga??lico escoc??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 's??rvio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'Serbo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shona.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'SINHALA.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'Eslovaco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'esloveno');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'Somali.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'Southern Sotho.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', 'espanhol');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'Swahili.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', 'sueco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tajik.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 't??mil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'T??rtaro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'tailand??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrya.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tongania');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'turco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'Turkmen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'ucraniano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'urdu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uyghur.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', 'Uzbeque');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'vietnamita');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'val??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'gal??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Fr??sia ocidental');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'I??diche');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'zulu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'N??o h?? dados dispon??veis para mostrar.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'Minha carteira');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'Voc?? comprou um produto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Produtos de venda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'Site inteiro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'Voc?? foi banido por violar nossos termos de uso. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Oops, voc?? foi banido de {site_name}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'Por favor, entre em contato conosco para mais detalhes.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'Anexar arquivo PDF.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Certificado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', 'Voc?? est?? trabalhando atualmente?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'N??o, eu estou olhando para trabalhar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'Sim estou procurando funcion??rios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Produtos para venda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'Voc?? n??o pode ver suas notifica????es porque voc?? foi banido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'Voc?? n??o pode ver suas mensagens porque foi banido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', 'Voc?? n??o pode ver seus pedidos porque voc?? foi banido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'Cancelamento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'Dinheiro foi recebido com sucesso de');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- Escreva seus Termos de Uso aqui. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<H4> 1- Escreva sobre o seu site aqui. </ H4> Lorem Ipsum Dolor Sente-se Amet, Consectetur Adipisicing Elit, SED DO EUIUSMOD TEMPORAM INCIDURAT UT Labore et Dolore Magna Aliqua. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<H4> 1- Escreva seus Termos de Uso aqui. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', 'Avaliou seu produto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', 'Compra de produtos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', 'Venda do produto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'Descreva sua revis??o aqui ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'produtos relacionados');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', 'Tem certeza de que deseja excluir?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', 'Tem certeza de que deseja excluir esses servi??os?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', 'Pesquisa, encontrar e aplicar ??s oportunidades de emprego em');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', 'Conecte-se com os amigos!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', 'Fa??a o login na sua conta {Site_Name} e conecte-se com seus amigos!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'Lembre-se deste dispositivo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', 'Crie sua conta {Site_Name}!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'Apenas os usu??rios pro podem fazer upload, por favor, atualize para pro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'Seu conte??do de postagem n??o pode estar vazio.');
        } else if ($value == 'russian') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', '???? ???????????? ???????????????? ?????????? ?????? ??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', '???????????????? ?? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', '?????????????? ???? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', '???????????????? ?? ?????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', '?????? ???? ?????????????? ?????????????? ?????? ??????????????, ????????????????????, ?????????????????? ???????? ??????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', '???? ?????????????????????? ???????????????? ???? ?????????????????? Pro.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', '???? ?????????????????????? ????????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', '?????????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', '???????????????????????????? ???? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', '???????????? ?????????????? ??????????????, ??????????????!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', '???????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', '?????????? ???????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', '???????????????????? ???????????????? ????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', '?? ?????????????????? ?????????? ????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', '???????????? ???? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', '?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', '???????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', '???????????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', '?????? ?????????? ?????? ?????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', '?????????????? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', '???? ??????????????, ?????? ???????????? ?????????????? ???????? ???????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', '?????????????????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', '?????? ?????????? ?????????????? ????????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', '????????????????????, ???????????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', '????????????????????, ???????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', '???? ?????????????????????? ???????????????????? ????????????????, ???? ???????????? ?????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', '?????????????????? ?? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', '?????????????????? ???????????????? ?????????????????????? ???? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', '?????????? ???? ?????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', '?????????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', '?????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', '?????? ?????????? ?????? ?????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', '???? ?????????????????? ???????????????? ???? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', '?????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'ID ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', '???? ?????? ???? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', '???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', '???????????????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', '???????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', '?????????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', '???????????????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', '???????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', '???????? ???????????? ???????????? ???? ?????? ???????????????????? ?????? ???????????????? ?? ?????????????? 60 ???????? ?? ???????? ????????????, ???? ?????????? ?????????????????????????? ?????????????????? ???? ????????????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', '???????? ?????????? ???? ?????????? ???????? ???? ?????? ??????????????????, ???????????????????? ?????????? ?????????????????? ????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', '?????????????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', '?????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', '???????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', '???? ?????????????????????? ?????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', '????????-??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', '???????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', '?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', '???????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', '???????????? ???? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Qty.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', '????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', '?????????????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', '?????????????????????????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', '???????????? ???? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', '???????????????????? ?? ???????????????????????? ???????? ?????????????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', '?????? ???????????????????????? ???? ?????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', '?????????? ???????????????????????? ???? ?????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', '????????????????????, ?????????????? ???????????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', '????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', '????????????????????, ?????????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', '?????? ???????????? ?????????????????? ?????? ??????????????????????????, ???? ???????????????? ?? ???????? ?????????? ????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', '???????????????????????? ???? ????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', '?????????? ?????????????????????? ??????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', '?????????????? ???? ?????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', '?????? ?????????? ?????? ??????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', '???????????? ???????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', '?????????? ???????????? ???????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', '?????????????????? ?????????????????????????? ????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', '?????? ?????????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', '?????? ?????????????? ?? ?????????????????? ?????????? ?????????????????? ?????? ??????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', '???????????????? ?????????? ?? ?????????????? Enter');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', '???????????????? ???? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', '?????????????? ???? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', '?????????????? ???? ?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', '???????????????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', '???????????????????? ?????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', '???????????????? ?????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', '???????????????? ?????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', '?????????????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', '?????????????? ???? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', '???????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', '???????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', '?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', '??????, ??????????, ???????????? ... ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', '???????????? ??????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', '????????????????????, ????????????????, ?????? ???? ???????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', '?????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', '?????????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', '?????????? ???????????????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', '?????????? ???????????????????? ???????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', '?????? ?????????????? ???? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', '?????????? ?????????? ?? #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', '?????????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', '???????? ?????????????????????? ???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', '???????????????????? ???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', '????????????????????, ???????????????? ???????? ?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', '???????????????????????????? ???????? ??????????????, ?????????????????? ????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', '?????????????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'PATREON ???????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', '???????????????? ?????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', '???????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', '?????? ??????????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', '???? ???????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', '???????????????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', '?????????????? ??????????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', '???????????????????????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', '????????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', '????????????????????, ?????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', '????????????????????, ?????????????? ???????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', '????????????????????, ?????????????? ?????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', '????????????????????, ?????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', '????????????????????, ?????????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', '????????????????????, ?????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', '????????????????????, ?????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', '????????????????????, ???????????????? ???????????????????? ????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', '???????? ?????????????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', '????????????????????, ?????????????? ???????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', '?????????????? ???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', '???? ??????????????, ?????? ???????????? ?????????????? ???????? ?????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', '???????? ????????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', '???? ???? ?????????????????? ????????????????????, ???? ???????????? ?????????????????? ?????? ????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', '???????? ?????????????? ????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', '????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', '???????????????? ?? ??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', '???????????????? ?????????? ????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', '?????????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', '?????????????? ???????????? ID.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', '???????????????????? ????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', '????????????????????, ?????????????? ?????????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', '???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', '???????? ?????????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', '????????????????????, ?????????????? ???????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', '????????????????????, ?????????????? ??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', '?????? ???????????????????? ?????? ????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', '?????????????? ???????? ????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', '???? ??????????????, ?????? ???????????? ?????????????? ???????? ?????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', '?????????????????????????? ????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', '?????? ???????????????????? ?????? ????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', '???????????????? ?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', '???????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', '???????????? ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'URL-?????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', '?????? ???????????? ?????? ????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', '?????????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', '???? ??????????????, ?????? ???????????? ?????????????? ???????? ?????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', '?????????????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', '?????? ???????????? ?????? ????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', '???????????? ?? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', '???????????? ????????-????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', '???????????????????? ?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', '???????????????????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', '???????????????? ?????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', '???????????????????? ??????, ?????????? ???????????? ???? ?????????????? ??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', '?????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', '???????????????? ?????????????? ????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', '???? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', '?????????????????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', '???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', '?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', '???????????????? ???????????? ???? ?????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', '???????????? ???????????????????????? ???? ?????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', '????????????????????, ???????????????? ?????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', '????????????????????, ???????????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', '?????????????????? ???????????? ???????? ??????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', '???????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', '???????????????? ?????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', '???????????????????????? ???? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', '?????????????? ???????????????? ???????????????? ?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', '???????????? ???? ?????????? ???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', '???????????? ???????? ??????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', '????????????, ??????????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', '???????????????? ID');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', '???????????? ???????? ??????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', '?????????????????????????? ?????????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', '???????????????????????? ?????????????? ???????? ???????? ??????????????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', '?????????????????? ???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', '????????????????, ?????? ???????????????????? ?????????? ????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Add Tier.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', '?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', '?????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', '?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', '???????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', '????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', '?????? ?????? ?????????? ?? ?????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', '?????? ???? ???????????????? ?????????????? ?? ?????? ????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', '?????? ?????? ?????????????????? ???????????? ?? ?? ????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', '?????? ?? ?????????? ?? ????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', '??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', '?????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', '???????? ???? ?????????? ???????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', '???????????????????????? ???? ?????????? ???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', '????????????????????, ???????????????? ?????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', '?????????????? ?????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', '?????????????????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', '?????????? ?????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', '?????????????? ???????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', '???? ??????????????, ?????? ???????????? ?????????????? ???????? ???????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', '????????????, ?????????????? ???? ???????????? ??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', '?????????????? ?????? ???????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amharic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', '?????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', '?????????????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', '?????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Corsican.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', '?????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', '?????????????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Faroese.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', '?????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', '??????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', '???????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', '?? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', '?????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', '?????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', '?????????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', '???????????????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', '???????????????????? Nynorsk.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', '??????????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romansh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', '?????????????????????? ??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', '??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', '?????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', '?????????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', '???????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', '??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'TWI');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', '????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', '??????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', '??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', '???????????????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'XHOSA');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', '????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'Zulu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', '?????? ?????????????????? ???????????? ?????? ??????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', '?????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', '???? ???????????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', '?????????????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', '???????? ????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', '???? ???????? ?????????????????? ???? ?????????????????? ?????????? ?????????????? ??????????????????????????. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', '??????, ???? ???????? ?????????????????? ?? {site_name}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', '????????????????????, ?????????????????? ?? ????????, ?????? ?????????? ?????????????????? ????????????????????.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', '???????????????????? PDF-????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', '????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', '???? ???????????? ???????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', '??????, ?? ???????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', '????, ?? ?????? ??????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', '?????????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', '???? ???? ???????????? ?????????????????????????? ???????? ??????????????????????, ???????????? ?????? ???? ???????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', '???? ???? ???????????? ?????????????????????????? ???????? ??????????????????, ???????????? ?????? ???? ???????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', '???? ???? ???????????? ?????????????????????????? ???????? ??????????????, ???????????? ?????? ???? ???????? ??????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', '????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', '???????????? ???????? ?????????????? ???????????????? ????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- ???????????????? ???????? ?????????????? ?????????????????????????? ??????????. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<H4> 1- ???????????????? ?? ?????????? ?????????? ??????????. </ H4> ???????????? Ipsum Dolor Sit Amet, Consenttur Adipisicing Elit, SED DO EUIUSMOD DEMORE INCIDIDUTTUTT UT LABORE ET DOLORE MAGNA ALIQUA. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<H4> 1- ???????????????? ???????? ?????????????? ?????????????????????????? ??????????. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', '?????????????????????? ?????? ??????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', '?????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', '?????????????? ????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', '?????????????? ???????? ?????????? ?????????? ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', '?????????????????????????? ????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', '???? ??????????????, ?????? ???????????? ???????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', '???? ??????????????, ?????? ???????????? ?????????????? ?????? ?????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', '??????????, ?????????? ?? ?????????????????? ?? ???????????????????????? ?????????????????????????????? ??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', '?????????????? ?? ????????????????!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', '?????????????? ?? ???????? ?????????????? ???????????? {site_name} ?? ???????????????????????? ?? ??????????????!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', '?????????????? ?????? ????????????????????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', '???????????????? ???????? ?????????????? ???????????? {site_name}!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', '???????????? ?????? ???????????????????????? ?????????? ?????????????????? ????????????????????, ???????????????? ???? Pro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', '?????? ?????????????? ?????????????????? ???? ?????????? ???????? ????????????.');
        } else if ($value == 'spanish') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'Debes agregar un texto o imagen.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'A??adir al carrito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Quitar del carrito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'Pagar por billetera');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'No tiene suficiente saldo para comprar, por favor, recargue su billetera.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'Est?? a punto de actualizar a un miembro profesional.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'Est??s a punto de donar.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'Se requiere la cantidad');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'La financiaci??n no se encuentra');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', 'Pago hecho con ??xito, ??Gracias!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', 'Compra ahora');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Unidades de elementos totales');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', 'Se requiere unidades de elementos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', 'Actualmente no disponible.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', 'Verificar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'No se encontraron art??culos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Total');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'Mis direcciones');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'A??adir nuevo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Agregar nueva direcci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Su direcci??n ha sido a??adida con ??xito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'Elimina tu direcci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', '??Est?? seguro de que desea eliminar esta direcci??n?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'Editar direcci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Su direcci??n ha sido editada con ??xito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'Por favor agregue una nueva direcci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'Por favor seleccione una direcci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', 'Alerta de pago');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', 'Est?? a punto de comprar los art??culos, ??desea continuar?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Carro de compras');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', 'Elementos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'Volver a la tienda');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Algunos productos est??n agotados.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'La direcci??n no puede estar vac??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Direcci??n no encontrada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'El carrito esta vac??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Su pedido ha sido realizado con ??xito.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'Comprado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'No se han encontrado art??culos comprados');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Pedido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'Descargar factura');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'Se requiere identificaci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'A??n no has comprado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Orden no encontrado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'Detalles de pedido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Escribir un comentario');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Solicitar un reembolso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'Detalles de seguimiento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Direcci??n de entrega');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'Si el estado del pedido no se configur?? para entregar dentro de 60 d??as a partir de la fecha del pedido, se enviar?? autom??ticamente a \"entregado\".');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'Si el pedido no fue realmente entregado, el comprador puede solicitar un reembolso.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Metido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', 'Pagos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'Total parcial');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Factura de venta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Nombre del vendedor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Email del vendedor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Factura a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', 'Detalles del pago');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Total de vencimiento');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'Nombre del banco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Factura');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Articulo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Pedidos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'No se han encontrado pedidos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', 'Productos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Cantidad');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', 'Cancelado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Aceptado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Lleno');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Enviado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'Comisi??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Precio final');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'El n??mero de rastreo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Enlace');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', 'La informaci??n de seguimiento se ha guardado correctamente');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', 'La URL de seguimiento no puede estar vac??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', 'El n??mero de seguimiento no puede estar vac??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'Por favor introduzca un URL v??lido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'Sitio URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Entregado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'Por favor explique la raz??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', 'Su solicitud est?? bajo revisi??n, nos ponemos en contacto con usted una vez hecho.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'Revisar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'Entregar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', 'Se requiere el contenido de revisi??n.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'la calificaci??n no puede estar vac??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', 'Su revisi??n ha sido enviada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'El estado del pedido ha sido cambiado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'Se han colocado nuevos pedidos.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'Informaci??n de seguimiento a??adido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', 'Su producto ha sido aprobado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', 'Su producto est?? actualmente bajo revisi??n.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'P??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Preguntar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', 'Escribe una respuesta y presiona ENTER');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'Responder a la respuesta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'respondi?? tu pregunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'respondi?? a tu respuesta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', 'Me gust?? tu pregunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', 'Me gust?? tu respuesta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'te mencion?? en una respuesta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'te mencion?? en una pregunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Compra verificada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'No se encontraron opiniones');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'Pregunta an??nimamente');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Preguntar a un amigo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Buscar amigos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'Qu??, cu??ndo, por qu?? ... pregunte');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'Se requiere la pregunta.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'Por favor, seleccione a quien desea preguntar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'te hizo una pregunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Preguntas de tendencia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', 'A la gente le gust?? esta pregunta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', 'A la gente le gusta esta respuesta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'No hay respuestas para mostrar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', 'B??squeda de personas y #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Preguntas');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Tweets de tendencia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', 'A la gente le gust?? este tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'Me gust?? su Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'Por favor seleccione un archivo para cargar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'Desbloquee este contenido convirti??ndose en un patr??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', '??nete ahora');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Membres??a patreon Price');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'Experiencia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'A??adir nueva experiencia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', 'Nombre de empresa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', 'Tipo de empleo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', 'Tiempo completo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', 'Medio tiempo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Trabajadores por cuenta propia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Lanza libre');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'Contrato');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'Internado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', 'Aprendizaje');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'Estacional');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Industria');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'Por favor ingrese un t??tulo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'Por favor ingrese un nombre de la empresa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'Por favor ingrese un tipo de empleo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'Por favor ingrese una ubicaci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'Por favor ingrese una fecha de inicio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'Por favor ingrese una industria');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'Por favor ingrese una descripci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'Por favor, elija una fecha correcta.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Experiencia creada con ??xito.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'Por favor ingrese un enlace v??lido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'Elimina tu experiencia');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', '??Est??s seguro de que quieres eliminar esta experiencia?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'EDITAR EXPERIENCIA');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'Usted no es el propietario, puede aplicar esta acci??n.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Experimente con ??xito actualizado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Certificaciones');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Licencias y Certificados');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'A??adir nuevo certificado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Organizaci??n emisora');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'ID de credencial');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'URL CREDENCIAL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'Por favor ingrese una organizaci??n emisora');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'Fecha de asunto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Fecha de caducidad');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'Por favor ingrese la fecha de emisi??n.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'Por favor ingrese un nombre');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Su certificado ha sido creado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'Elimina tu certificado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', '??Est?? seguro de que desea eliminar este certificado?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', 'Editar certificado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Su certificado ha sido actualizado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Proyectos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'A??adir nuevo proyecto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Nombre del proyecto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', 'Asociado con');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'URL del proyecto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Su proyecto ha sido a??adido.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'Elimina tu proyecto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', '??Est?? seguro de que desea eliminar este proyecto?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Editar proyecto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Su proyecto ha sido actualizado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'Habilidades');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'Idiomas');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'Abierto a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Encontrar un nuevo trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Prestaci??n de servicios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', 'Contrataci??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', 'A??adir preferencias de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Dinos qu?? tipo de trabajo est??s abierto a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', 'Lugar de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', 'T??tulos de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'En el sitio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'H??brido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', 'Remoto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', 'Tipos de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Temporal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', 'Locaci??n de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', 'El t??tulo del trabajo no puede estar vac??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', 'La ubicaci??n del trabajo no puede estar vac??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'Por favor seleccione un lugar de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'Por favor seleccione un tipo de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', 'Las preferencias de trabajo se han actualizado.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', 'Abierto al trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'Ver todos los detalles');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', 'Preferencias de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Configuremos su p??gina de servicios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Servicios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'Los servicios no pueden estar vac??os.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'Se han guardado los servicios.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Servicios prestados');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'Identificaci??n invalida');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'Se han actualizado los servicios.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', 'Editar Preferencias de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', 'Se han editado las preferencias de trabajo.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Cargar m??s servicios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Gr??ficos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'Elige qu?? ofrecer a tus clientes.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Agregar un nivel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'T??tulo del nivel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Precio de nivel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Imagen de nivel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Descripci??n del nivel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Beneficios');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Chat sin audio y videollamada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Chatea con llamada de audio y sin videollamada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Chat sin llamada de audio y con videollamada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Chatea con audio y videollamada.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Chat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Corriente');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'El precio no puede estar vac??o');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'Los beneficios no pueden estar vac??os');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'Por favor seleccione el tipo de chat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Nivel agregado con ??xito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Editar nivel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Nivel actualizado con ??xito');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'Elimina tu nivel');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', '??Est??s seguro de que quieres eliminar este nivel?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'Patr??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'Patrones');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Servicios que te guste');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', 'Abierto a publicaciones de trabajo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'africaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'alban??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Am??rico');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', 'Ar??bica');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'aragon??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'armenio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'asturiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'Azerbaiyano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'vasco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Bielorruso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'bengal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'bosnio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'Bret??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'b??lgaro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'catal??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Kurdo central');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', 'chino');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'corso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'croata');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', 'checo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'dan??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'holand??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'ingl??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'esperanto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'Estonio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Feroz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Filipino');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'finland??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'franc??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'gallego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'georgiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'alem??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'griego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guaran??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'hawaiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', 'hebreo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'hindi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'h??ngaro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', 'island??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'indonesio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', 'irlandesa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', 'italiano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'japon??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Kazakh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'coreano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'kurdo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'Kirguisa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'lat??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'let??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'lituano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'maced??nio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'malayo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'malt??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'mongol');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'Nepal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'noruego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Bokm??l noruego');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Noruego Nynorsk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'Oriya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'Pashto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'persa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'polaco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'portugu??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'punjabi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'quechua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'rumano');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romansh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'ruso');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', 'ga??lico escoc??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 'serbio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'Serbo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shona');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'Sinhala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'eslovaco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'esloveno');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'somal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'Southern Sotho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', 'espa??ol');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundana');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'swahili');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', 'sueco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tajik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 'Tamil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'T??rtaro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'tailand??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrinosa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tongan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'turco');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'Turkmen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'ucranio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'Urdu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uyghur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', 'Uzbeko');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'vietnamita');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'Val??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'gal??s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Frise occidental');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'y??dish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'zul??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'No hay datos disponibles para mostrar.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'Mi billetera');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'Has comprado un producto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Venta Products');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'Todo el sitio');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'Fuiste prohibido por violar nuestros T??rminos de uso. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Uy, fuiste prohibido desde {Site_Name}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'Por favor, p??ngase en contacto con nosotros para m??s detalles.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'Adjuntar archivo PDF');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Certificado');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', 'Estas trabajando?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'No, estoy buscando trabajar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'Si estoy buscando empleados');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Productos en venta');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'No puedes ver tus notificaciones porque estabas prohibido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'No puedes ver tus mensajes porque estabas prohibido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', 'No puedes ver tus peticiones porque estabas prohibido');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'Retiro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'El dinero fue recibido con ??xito de');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- Escribe tus T??rminos de uso aqu??. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<H4> 1- Escriba sobre su sitio web aqu??. </ h4> lorem ipsum dolors sitt amet, consectetur adipizing elit, sed do eiusmod temporal incididunt UT Labore et Dolore Magna Aliqua. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<H4> 1- Escribe tus T??rminos de uso aqu??. </ H4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', 'revisado su producto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', 'Compra de productos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', 'Venta de productos');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'Describe tu revisi??n aqu?? ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'Productos relacionados');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', '??Estas seguro que quieres borrarlo?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', '??Est?? seguro de que desea eliminar estos servicios?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', 'Buscar, encontrar y solicitar oportunidades de trabajo en');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', '??Conecta con amigos!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', 'Inicie sesi??n en su cuenta {Site_Name} y conecte con sus amigos!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'recuerda este dispositivo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', '??Crea tu cuenta {Site_Name}!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'S??lo los usuarios de PRO pueden subir por favor actualizar a PRO');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'Su contenido de publicaci??n no puede estar vac??o.');
        } else if ($value == 'turkish') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'Bir metin veya resim eklemelisiniz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'Sepete ekle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Arabadan ????kar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'C??zdan taraf??ndan ??deme');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'Sat??n almak i??in yeterli dengeniz yok, l??tfen c??zdan??n??z?? doldurun.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'Bir Pro ??yesine y??kseltmek ??zeresiniz.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'Ba?????? yapmak ??zeresin.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'Tutar gereklidir');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'Finansman bulunamad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', '??deme ba??ar??yla yap??ld??, te??ekk??r ederim!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', '??imdi sat??n al');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Toplam ??r??n Birimleri');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', '????e Birimleri Gerekli');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', '??u anda kullan??lam??yor.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', '??deme');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'hi?? bir ????e bulunamad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Toplam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'Adresim');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'Yeni ekle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Yeni adres ekleyin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Adresiniz ba??ar??yla eklendi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'Adresinizi Sil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', 'Bu adresi silmek istedi??inize emin misiniz?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'Adresi d??zelt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Adresiniz ba??ar??yla d??zenlendi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'L??tfen yeni bir adres ekle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'L??tfen bir adres se??in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', '??deme uyar??s??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', '????eleri sat??n almak ??zeresiniz, devam etmek ister misiniz?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Al????veri?? Sepeti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', '????eler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'D??kkana geri d??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Baz?? ??r??nler stokta yok.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'Adres bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Adres bulunamad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'Kart bo??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Sipari??iniz ba??ar??yla verildi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'sat??n al??nd??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'Sat??n al??nan ??r??n bulunamad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Emir');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'Faturay?? indirin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'Kimlik gereklidir');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'Hen??z sat??n almad??n??z.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Sipari?? bulunamad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'Sipari?? detaylar??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Yorum yaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Geri ??deme istemek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'Y??r??y???? detaylar??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Teslimat adresi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'Sipari?? durumu, sipari?? tarihinden itibaren 60 g??n i??inde teslim edilmemi??se, otomatik olarak \"teslim\" i??in g??nderilir.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'Sipari?? asl??nda teslim edilmediyse, al??c?? bir geri ??deme talebinde bulunabilir.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Yerle??tirilmi??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', '??deme');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'ara toplam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Sat???? faturas??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Sat??c?? Ad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Sat??c?? e-postas??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Fatura');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', '??deme detaylar??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Tam olarak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'banka ad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Fatura');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Kalem');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Emirler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'sipari?? bulunamad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', '??r??n:% s');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Qty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', '??ptal edildi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Kabul edilmi??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Paketlenmi??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Sevk edilen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'komisyon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Son fiyat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'Takip numaras??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Ba??lant??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', '??zleme bilgisi ba??ar??yla kaydedildi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', '??zleme URL\'si bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', '??zleme numaras?? bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'L??tfen ge??erli bir adres girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'Site URL\'si');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Teslim edilmi??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'L??tfen nedeni a????klay??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', '??ste??iniz inceleme alt??nda, bir kez yapt??ktan sonra sizinle ileti??im kuruyoruz.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'G??zden ge??irmek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'G??ndermek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', '??nceleme i??eri??i gereklidir.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'derecelendirme bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', '??ncelemeniz g??nderildi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'Sipari?? durumu de??i??tirildi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'Yeni sipari??ler yerle??tirildi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'Eklenen ??zleme Bilgisi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', '??r??n??n??z onayland??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', '??r??n??n??z ??u anda incelenmektedir.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'C??v??ldamak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Sor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', 'Bir cevap yaz??n ve Enter tu??una bas??n.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'Cevapla cevap');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'Sorunuzu cevaplad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'cevab??n??za cevap verdi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', 'Sorunu be??endi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', 'Cevab??n?? be??endim');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'bir cevaptan bahsetti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'bir sorudan bahsetti');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Do??rulanm???? Sat??nalma');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'Yorum bulunamad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'Anonim olarak sor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Arkada????na sor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Arkada??lar??n?? ara');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'Ne, ne zaman, neden ... sor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'Soru gereklidir.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'L??tfen kimi sormak istedi??inizi se??in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'Sana bir soru sordu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Trending sorular??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', '??nsanlar bu soruyu sevdim');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', '??nsanlar bu cevab?? be??endi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'G??stermede cevap yok');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', '??nsanlar?? aray??n ve #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Sorular');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Trend Tweetler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', '??nsanlar bu tweet\'i sevdim');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'Tweet\'ini be??endim');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'L??tfen y??klenecek bir dosya se??in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'Patron olarak bu i??eri??in kilidini a??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', '??imdi Kat??l');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Patreon ??yelik Fiyat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'Tecr??be etmek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'Yeni Deneyim Ekle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', '??irket Ad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', '??stihdam Tipi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', 'Tam zamanl??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', 'Yar?? zamanl??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Kendi i??inde ??al????an');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Serbest');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'S??zle??me');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'Staj');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', '????rakl??k');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'Mevsimlik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Sanayi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'L??tfen bir ba??l??k girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'L??tfen bir ??irket ad??n?? girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'L??tfen bir i?? t??r?? girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'L??tfen bir yer girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'L??tfen bir ba??lang???? ??????tarihi girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'L??tfen bir end??stri girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'L??tfen bir a????klama girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'L??tfen do??ru bir tarih se??iniz.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Ba??ar??yla yarat??lm???? deneyim.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'L??tfen ge??erli bir ba??lant?? girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'Deneyiminizi Sil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', 'Bu deneyimi silmek istedi??inize emin misiniz?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'Deneyimi d??zenle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'Sen sahibi de??ilsin, bu i??lemi uygulayabilirsiniz.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Deneyim ba??ar??yla g??ncellendi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Sertifikalar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Lisanslar ve Sertifikalar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'Yeni sertifika ekle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Organizasyon D??zenleyen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'Kimlik bilgisi kimli??i');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'Kimlik bilgisi URL\'si');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'L??tfen veren bir organizasyon girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'D??zenleme tarihi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Son kullanma tarihi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'L??tfen ihra?? tarihini girin.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'L??tfen bir isim girin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Sertifikan??z olu??turuldu.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'Sertifikan??z?? Sil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', 'Bu sertifikay?? silmek istedi??inize emin misiniz?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', 'Sertifika D??zenle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Sertifikan??z g??ncellendi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Projeler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'Yeni Proje Ekle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Proje Ad??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', '??le ili??kili');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'Proje URLsi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Projeniz eklendi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'Projenizi silin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', 'Bu projeyi silmek istedi??inize emin misiniz?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Projeyi D??zenle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Projeniz g??ncellendi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'Yetenekler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'Diller');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'A??mak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Yeni bir i?? bulmak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Servis sa??lama');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', '????e al??yor');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', '???? Tercihleri ??????Ekleme');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Bize ne t??r bir i??in a????ld??????n?? s??yle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', '????yerleri');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', '???? ??nvanlar??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'Yerinde');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'Hibrit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', 'Uzak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', '???? t??rleri');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Ge??ici');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', '???? konumu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', '???? unvan?? bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', '???? yeri bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'L??tfen bir i?? yeri se??iniz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'L??tfen bir i?? t??r??n?? se??in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', '???? tercihleri ??????g??ncellendi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', '????e a????k');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'T??m detaylar?? g??r');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', '???? tercihleri');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Hizmetlerinizi ayarlayal??m');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Hizmetler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'Hizmetler bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'Hizmetler kaydedildi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Sa??lanan Hizmetler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'Ge??ersiz kimlik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'Hizmetler g??ncellendi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', '???? Tercihlerini D??zenle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', '???? tercihleri ??????d??zenlendi.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Daha fazla hizmet y??kleyin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Katmanlar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'M????terilerinize ne sunaca????n??z?? se??in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Katman eklemek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'Tier ba??l??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Katmanl?? Fiyat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Katmanl?? g??r??nt??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Tier A????klama');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Faydalar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Ses ve g??r??nt??l?? arama olmadan sohbet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Ses aramas?? ile sohbet edin ve g??r??nt??l?? arama yapmadan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Sesli arama olmadan sohbet edin ve g??r??nt??l?? g??r????me');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Ses ve g??r??nt??l?? g??r????me ile sohbet et');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Sohbet etmek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Canl?? yay??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'Fiyat bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'Faydalar?? bo?? olamaz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'L??tfen sohbet t??r??n?? se??in');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Tier ba??ar??yla eklendi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Tier D??zenle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Tier ba??ar??yla g??ncellendi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'Seviyeni sil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', 'Bu kademeyi silmek istedi??inize emin misiniz?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'Patron');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'Patronlar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Be??enebilece??iniz hizmetler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', '???? g??nderilerine a????k');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'AfrikaAl??lar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'Arnavut');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amhar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', 'Arap??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'Aragonca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'Ermeni');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'Asturyal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'Azerbaycan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'Bask??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Belarus??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'Bengal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'Bo??nak??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'Breton');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'Bulgarca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'Katalanca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Orta K??rt??e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', '??ince');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Korsikal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'H??rvat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', '??ek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'Danimarkal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'Flemenk??e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'ingilizce');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'Esperanto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'Estonyal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Faroese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Filipo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'Fince');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'Frans??zca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'Galerici');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'G??rc??ce');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'Almanca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'Yunan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guarani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'Hawaii');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', '??branice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'Hint??e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'Macarca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', '??zlandaca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'Endonezyac??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', '??nterlingua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', '??rlandal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', '??talyan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'Japonca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Kazak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'Koreli');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'K??rt');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'K??rg??z');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'Latince');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'Letonyal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'Litvanyal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'Makedonyal??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'Malay');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'Maltaca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'Mo??olca');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'Nepal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'Norve????e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Norve?? Bokm??l');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Norve?? Nynorsk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'Oriya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Orom');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'P??lye');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'Fars??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'Leh??e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'Portekizce');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'Punjabi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'Quechua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'Romence');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romansh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'Rus??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', '??sko?? gaeli');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 'S??rp??a');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'S??rp');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'Sinhala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'Slovak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'Slovence');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'Somali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'G??ney Sotho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', '??spanyol');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'Svahili');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', '??sve????e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tacik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 'Tamil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'Tatar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'Tayland');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrinya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tongan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'T??rk??e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'T??rkmen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'Ukrayna');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'Urdu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uygur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', '??zbek??e');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'Vietnam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'Valon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'Gasp');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Bat?? frizi??i');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'Yidi??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'Zulu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'G??sterilecek mevcut veri yok.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'C??zdan??m');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'Bir ??r??n ald??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Sat???? ??r??nler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'T??m site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'Kullan??m ??artlar??m??z?? ihlal etti??iniz i??in yasakland??n??z. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Oops, {sitesi_name} \'dan yasakland??n??z.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'Daha fazla ayr??nt?? i??in l??tfen {Contact_US}.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'PDF dosyas??n?? ekle');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Sertifika');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', '??u anda ??al??????yor musun?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'Hay??r ??al????mak istiyorum');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'Evet ??al????anlar?? ar??yorum');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Sat??l??k ??r??nler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'Bildirimlerinizi g??remezsiniz ????nk?? yasakland??n??z');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'Mesajlar??n??z?? g??r??nt??leyemezsiniz ????nk?? sen yasakland??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', '??steklerinizi g??remezsiniz, ????nk?? sen yasakland??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'Para ??ekme');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'Para ba??ar??yla al??nd??');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<H4> 1- Burada kullan??m ??artlar??n??z?? yaz??n. </ h4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<H4> 1- Burada web sitenizi yaz??n. </ h4> Lorem Ipsum Dolor Sit Amet, Konsestan Adipising Elit, SED, EIUSMOD TABLOSYONU T??RK??YETUTT UT Labore et Dolore Magna Aliqua. ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<H4> 1- Burada kullan??m ??artlar??n??z?? yaz??n. </ h4>
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', '??r??n??n??z?? g??zden ge??irdi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Sikke');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', '??r??n sat??n alma');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', '??r??n sat??????');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'Buradaki yorumunuzu a????klay??n ..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'ilgili ??r??nler');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', 'Silmek istedi??ine emin misin?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', 'Bu hizmetleri silmek istedi??inize emin misiniz?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', '???? f??rsatlar??n?? aray??n, bulun ve uygulay??n');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', 'Arkada??larla ba??lant?? kur!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', '{Site_Name} hesab??n??za giri?? yap??n ve arkada??lar??n??zla ileti??im kurun!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'Bu cihaz?? hat??rla');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', '{Site_NAME} hesab??n??z?? olu??turun!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'Sadece Pro Kullan??c??lar l??tfen Pro\'ya y??kseltebilir');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'G??nderiniz bo?? olamaz.');
        } else if ($value == 'english') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'You must add a text or image');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'Add To Cart');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Remove From Cart');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'Pay By Wallet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'You don\'t have enough balance to purchase, please top up your wallet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'You are about to upgrade to a PRO memeber.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'You are about to donate.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'Amount is required');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'Funding is not found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', 'Payment successfully done, thank you!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', 'Buy Now');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Total Item Units');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', 'Item units is required');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', 'Currently unavailable.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', 'Checkout');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'No items found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Total');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'My Addresses');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'Add New');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Add New Address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Your address has been added successfully');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'Delete your address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', 'Are you sure you want to delete this address?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'Edit Address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Your address has been edited successfully');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'Please add a new address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'Please select an address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', 'Payment Alert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', 'You are about to purchase the items, do you want to proceed?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Shopping Cart');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', 'Items');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'Back to shop');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Some products are out of stock.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'Address can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Address not found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'Cart is empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Your order has been placed successfully');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'Purchased');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'No purchased items found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Order');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'Download Invoice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'ID is required');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'You haven\'t purchased yet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Order not found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'Order details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Write Review');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Request a Refund');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'Tracking Details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Delivery Address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'If the order status wasn\'t set to delivered within 60 days from the order date, it will be automatically be sent to "Delivered".');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'If the order wasn\'t actually delivered, the buyer can request a refund.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Placed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', 'Payments');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'Subtotal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Sale invoice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Seller Name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Seller Email');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Invoice To');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', 'Payment Details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Total Due');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'Bank name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Invoice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Item');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Orders');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'No orders found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', 'Products');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Qty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', 'Canceled');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Accepted');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Packed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Shipped');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'Commission');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Final Price');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'Tracking Number');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Link');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', 'Tracking info has been saved successfully');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', 'Tracking url can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', 'Tracking number can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'Please enter a valid url');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'Site Url');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Delivered');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'Please explain the reason');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', 'Your request is under review, we contact you once done.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'Review');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'Submit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', 'Review content is required.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'rating can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', 'Your review has been submitted.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'order status has been changed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'new orders has been placed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'added tracking info');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', 'your product has been approved');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', 'Your product is currently under review.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Ask');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', 'Write an answer and press enter');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'Reply to answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'answered your question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'replied to your answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', 'liked your question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', 'liked your answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'mentioned you on an answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'mentioned you on a question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Verified Purchase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'No reviews found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'Ask anonymously');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Ask friend');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Search for friends');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'What, when, why??? ask');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'Question is required.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'Please select who you want to ask');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'asked you a question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Trending Questions');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', 'People liked this question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', 'People liked this answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'No answers to show');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', 'Search for people and #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Questions');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Trending Tweets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', 'People liked this tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'liked your tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'Please select a file to upload');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'Unlock this content by becoming a patron');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', 'Join now');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Patreon membership price');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'Experience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'Add New Experience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', 'Company name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', 'Employment type');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', 'Full time');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', 'Part time');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Self employed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Freelance');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'Contract');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'Internship');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', 'Apprenticeship');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'Seasonal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Industry');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'Please enter a title');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'Please enter a company name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'Please enter a employment type');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'Please enter a location');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'Please enter a start date');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'Please enter an industry');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'Please enter a description');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'Please choose a correct date.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Experience successfully created.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'Please enter a valid link');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'Delete your experience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', 'Are you sure you want to delete this experience?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'Edit experience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'You are not the owner, you can apply this action.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Experience successfully updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Certifications');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Licenses & Certificates');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'Add New Certificate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Issuing organization');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'Credential ID');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'Credential URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'Please enter an issuing organization');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'Issue date');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Expiration date');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'Please enter the issuing date.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'Please enter a name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Your certificate has been created.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'Delete your certificate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', 'Are you sure you want to delete this certificate?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', 'Edit Certificate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Your certificate has been updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Projects');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'Add new project');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Project name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', 'Associated with');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'Project URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Your project has been added.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'Delete your project');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', 'Are you sure you want to delete this project?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Edit Project');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Your project has been updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'Skills');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'Languages');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'Open To');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Finding a new job');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Providing services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', 'Hiring');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', 'Add job preferences');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Tell us what kind of work you???re open to');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', 'Workplaces');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', 'Job titles');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'On site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'Hybrid');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', 'Remote');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', 'Job types');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Temporary');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', 'Job location');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', 'Job title can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', 'Job location can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'Please select a workplace');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'Please select a job type');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', 'Job preferences have been updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', 'Open to work');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'See all details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', 'Job preferences');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Let???s set up your services page');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'Services can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'Services have been saved.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Services provided');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'Invalid id');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'Services have been updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', 'Edit job preferences');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', 'Job preferences have been edited.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Load more services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Tiers');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'Choose what to offer your patrons');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Add tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'Tier title');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Tier price');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Tier image');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Tier description');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Benefits');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Chat without audio and video call');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Chat with audio call and without video call');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Chat without audio call and with video call');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Chat with audio and video call');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Chat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Live Stream');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'Price can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'Benefits can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'Please select the chat type');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Tier successfully added');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Edit tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Tier successfully updated');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'Delete your tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', 'Are you sure you want to delete this tier?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'Patron');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'Patrons');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Services you may like');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', 'Open to work posts');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'Afrikaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'Albanian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amharic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', 'Arabic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'Aragonese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'Armenian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'Asturian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'Azerbaijani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'Basque');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Belarusian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'Bengali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'Bosnian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'Breton');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'Bulgarian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'Catalan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Central Kurdish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', 'Chinese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Corsican');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'Croatian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', 'Czech');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'Danish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'Dutch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'English');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'Esperanto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'Estonian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Faroese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Filipino');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'Finnish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'French');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'Galician');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'Georgian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'German');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'Greek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guarani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'Hawaiian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', 'Hebrew');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'Hindi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'Hungarian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', 'Icelandic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'Indonesian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', 'Irish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', 'Italian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'Japanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Kazakh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'Korean');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'Kurdish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'Kyrgyz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'Latin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'Latvian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'Lithuanian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'Macedonian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'Malay');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'Maltese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'Mongolian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'Nepali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'Norwegian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Norwegian Bokm??l');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Norwegian Nynorsk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'Oriya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'Pashto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'Persian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'Polish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'Portuguese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'Punjabi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'Quechua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'Romanian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romansh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'Russian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', 'Scottish Gaelic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 'Serbian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'Serbo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shona');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'Sinhala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'Slovak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'Slovenian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'Somali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'Southern Sotho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', 'Spanish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'Swahili');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', 'Swedish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tajik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 'Tamil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'Tatar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'Thai');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrinya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tongan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'Turkish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'Turkmen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'Ukrainian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'Urdu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uyghur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', 'Uzbek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'Vietnamese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'Walloon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'Welsh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Western Frisian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'Yiddish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'Zulu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'No available data to show.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'My Wallet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'You have bought a product');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Sale products');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'Entire Site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'You were banned for violating our terms of use. Please {contact_us} for more details.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Oops, You were banned from {site_name}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'Please {contact_us} for more details.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'Attach PDF File');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Certificate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', 'Are you currently working?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'No I am looking to work');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'Yes I am looking for employees');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Products for sale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'You can\'t view your notifications because you were banned');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'You can\'t view your messages because you were banned');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', 'You can\'t view your requests because you were banned');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'Withdrawal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'Money was successfully received from');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<h4>1- Write your Terms Of Use here.</h4>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.          <br><br>          <h4>2- Random title</h4>          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '<h2>Who we are?</h2>
      Provide name and contact details of the data controller. This will typically be your business or you, if you are a sole trader. Where applicable, you should include the identity and contact details of the controller???s representative and/or the data protection officer.

      <h2>What information do we collect?</h2>
      Specify the types of personal information you collect, eg names, addresses, user names, etc. You should include specific details on:
      how you collect data (eg when a user registers, purchases or uses your services, completes a contact form, signs up to a newsletter, etc)
      what specific data you collect through each of the data collection method
      if you collect data from third parties, you must specify categories of data and source
      if you process sensitive personal data or financial information, and how you handle this
      <br><br>
      You may want to provide the user with relevant definitions in relation to personal data and sensitive personal data.
      <br><br>
      <h2>How do we use personal information?</h2>
      Describe in detail all the service- and business-related purposes for which you will process data. For example, this may include things like:
      personalisation of content, business information or user experience
      account set up and administration
      delivering marketing and events communication
      carrying out polls and surveys
      internal research and development purposes
      providing goods and services
      legal obligations (eg prevention of fraud)
      meeting internal audit requirements
      <br><br>
      Please note this list is not exhaustive. You will need to record all purposes for which you process personal data.
      <br><br>
      <h2>What legal basis do we have for processing your personal data?</h2>
      Describe the relevant processing conditions contained within the GDPR. There are six possible legal grounds:
      consent
      contract
      legitimate interests
      vital interests
      public task
      legal obligation
      <br><br>
      Provide detailed information on all grounds that apply to your processing, and why. If you rely on consent, explain how individuals can withdraw and manage their consent. If you rely on legitimate interests, explain clearly what these are.
      <br><br>
      If you???re processing special category personal data, you will have to satisfy at least one of the six processing conditions, as well as additional requirements for processing under the GDPR. Provide information on all additional grounds that apply.
      <br><br>
      <h2>When do we share personal data?</h2>
      Explain that you will treat personal data confidentially and describe the circumstances when you might disclose or share it. Eg, when necessary to provide your services or conduct your business operations, as outlined in your purposes for processing. You should provide information on:
      how you will share the data
      what safeguards you will have in place
      what parties you may share the data with and why

      <h2>Where do we store and process personal data?</h2>
      If applicable, explain if you intend to store and process data outside of the data subject???s home country. Outline the steps you will take to ensure the data is processed according to your privacy policy and the applicable law of the country where data is located.

      If you transfer data outside the European Economic Area, outline the measures you will put in place to provide an appropriate level of data privacy protection. Eg contractual clauses, data transfer agreements, etc.

      <h2>How do we secure personal data?</h2>
      Describe your approach to data security and the technologies and procedures you use to protect personal information. For example, these may be measures:
      to protect data against accidental loss
      to prevent unauthorised access, use, destruction or disclosure
      to ensure business continuity and disaster recovery
      to restrict access to personal information
      to conduct privacy impact assessments in accordance with the law and your business policies
      to train staff and contractors on data security
      to manage third party risks, through use of contracts and security reviews
      <br><br>
      Please note this list is not exhaustive. You should record all mechanisms you rely on to protect personal data. You should also state if your organisation adheres to certain accepted standards or regulatory requirements.
      <br><br>
      <h2>How long do we keep your personal data for?</h2>
      Provide specific information on the length of time you will keep the information for in relation to each processing purpose. The GDPR requires you to retain data for no longer than reasonably necessary. Include details of your data or records retention schedules, or link to additional resources where these are published.
      <br><br>
      If you cannot state a specific period, you need to set out the criteria you will apply to determine how long to keep the data for (eg local laws, contractual obligations, etc)
      <br><br>
      You should also outline how you securely dispose of data after you no longer need it.
      <br><br>
      <h2>Your rights in relation to personal data</h2>
      Under the GDPR, you must respect the right of data subjects to access and control their personal data. In your privacy notice, you must outline their rights in respect of:
      access to personal information
      correction and deletion
      withdrawal of consent (if processing data on condition of consent)
      data portability
      restriction of processing and objection
      lodging a complaint with the Information Commissioner???s Office

      You should explain how individuals can exercise their rights, and how you plan to respond to subject data requests. State if any relevant exemptions may apply and set out any identity verifications procedures you may rely on.

      Include details of the circumstances where data subject rights may be limited, eg if fulfilling the data subject request may expose personal data about another person, or if you???re asked to delete data which you are required to keep by law.

      <h2>Use of automated decision-making and profiling</h2>
      Where you use profiling or other automated decision-making, you must disclose this in your privacy policy. In such cases, you must provide details on existence of any automated decision-making, together with information about the logic involved, and the likely significance and consequences of the processing of the individual.

      <h2>How to contact us?</h2>
      Explain how data subject can get in touch if they have questions or concerns about your privacy practices, their personal information, or if they wish to file a complaint. Describe all ways in which they can contact you ??? eg online, by email or postal mail.
      <br><br>
      If applicable, you may also include information on:
      <br><br>
      <h2>Use of cookies and other technologies</h2>
      You may include a link to further information, or describe within the policy if you intend to set and use cookies, tracking and similar technologies to store and manage user preferences on your website, advertise, enable content or otherwise analyse user and usage data. Provide information on what types of cookies and technologies you use, why you use them and how an individual can control and manage them.
      <br><br>
      Linking to other websites / third party content
      If you link to external sites and resources from your website, be specific on whether this constitutes endorsement, and if you take any responsibility for the content (or information contained within) any linked website.
      <br><br>
      You may wish to consider adding other optional clauses to your privacy policy, depending on your business??? circumstances.
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<h4>1- Write about your website here.</h4>          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.          <br><br>          <h4>2- Random title</h4>          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dxzcolore magna aliqua. Ut enim ad minim veniam,          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<h4>1- Write your Terms Of Use here.</h4>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.          <br><br>          <h4>2- Random title</h4>          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', 'reviewed your product');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', 'Product Purchase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', 'Product Sale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'Describe your review here..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'Related Products');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', 'Are you sure you want to delete?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', 'Are you sure you want to delete these services?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', 'Search, find and apply to job opportunities at');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', 'Connect with friends!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', 'Login into your {site_name} account and connect with your friends!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'Remember this device');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', 'Create your {site_name} Account!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'Just Pro users can upload Please upgrade to pro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'Your post content can\'t be empty.');
        } else if ($value != 'english') {
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_must_add_text_or_image_first', 'You must add a text or image');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_to_cart', 'Add To Cart');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remove_from_cart', 'Remove From Cart');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_from_wallet', 'Pay By Wallet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_top_up_wallet', 'You don\'t have enough balance to purchase, please top up your wallet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_upgrade', 'You are about to upgrade to a PRO memeber.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pay_to_fund', 'You are about to donate.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'amount_can_not_empty', 'Amount is required');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'fund_not_found', 'Funding is not found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_successfully_done', 'Payment successfully done, thank you!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'buy_now', 'Buy Now');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item', 'Total Item Units');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_item_not_empty', 'Item units is required');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'currently_unavailable', 'Currently unavailable.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'checkout', 'Checkout');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_items_found', 'No items found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total', 'Total');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_addresses', 'My Addresses');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new', 'Add New');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_address', 'Add New Address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_added', 'Your address has been added successfully');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_address', 'Delete your address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_address', 'Are you sure you want to delete this address?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_address', 'Edit Address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_edited', 'Your address has been edited successfully');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_add_address', 'Please add a new address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_address', 'Please select an address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_alert', 'Payment Alert');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchase_the_items', 'You are about to purchase the items, do you want to proceed?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shopping_cart', 'Shopping Cart');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'items', 'Items');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'back_to_shop', 'Back to shop');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'some_products_units', 'Some products are out of stock.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_can_not_be_empty', 'Address can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'address_not_found', 'Address not found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'card_is_empty', 'Cart is empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_order_has_been_placed_successfully', 'Your order has been placed successfully');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'purchased', 'Purchased');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_purchased_found', 'No purchased items found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order', 'Order');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'download_invoice', 'Download Invoice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'id_can_not_empty', 'ID is required');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_are_not_purchased', 'You haven\'t purchased yet.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_not_found', 'Order not found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'order_details', 'Order details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_review', 'Write Review');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'request_refund', 'Request a Refund');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_details', 'Tracking Details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivery_address', 'Delivery Address');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_status', 'If the order status wasn\'t set to delivered within 60 days from the order date, it will be automatically be sent to "Delivered".');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'if_the_order_delivered', 'If the order wasn\'t actually delivered, the buyer can request a refund.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'placed', 'Placed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payments', 'Payments');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'subtotal', 'Subtotal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_invoice', 'Sale invoice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_name', 'Seller Name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seller_email', 'Seller Email');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice_to', 'Invoice To');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'payment_details', 'Payment Details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'total_due', 'Total Due');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'bank_name', 'Bank name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invoice', 'Invoice');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'item', 'Item');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'orders', 'Orders');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_orders_found', 'No orders found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products', 'Products');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'qty', 'Qty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'canceled', 'Canceled');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'accepted', 'Accepted');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'packed', 'Packed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'shipped', 'Shipped');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'commission', 'Commission');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'final_price', 'Final Price');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number', 'Tracking Number');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'link', 'Link');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_info_has_been_saved_successfully', 'Tracking info has been saved successfully');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_url_can_not_be_empty', 'Tracking url can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tracking_number_can_not_be_empty', 'Tracking number can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_enter_valid_url', 'Please enter a valid url');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'site_url', 'Site Url');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delivered', 'Delivered');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_explain_the_reason', 'Please explain the reason');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_request_is_under_review', 'Your request is under review, we contact you once done.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review', 'Review');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'submit', 'Submit');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_can_not_be_empty', 'Review content is required.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'rating_can_not_be_empty', 'rating can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'review_has_been_sent_successfully', 'Your review has been submitted.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'admin_status_changed', 'order status has been changed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'new_orders_has_been_placed', 'new orders has been placed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_tracking_info', 'added tracking info');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_approved', 'your product has been approved');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_product_is_under_review', 'Your product is currently under review.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweet', 'Tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask', 'Ask');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'write_answer', 'Write an answer and press enter');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'reply_to_answer', 'Reply to answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answered_your_question', 'answered your question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'replied_to_answer', 'replied to your answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_question', 'liked your question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_answer', 'liked your answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'answer_mention', 'mentioned you on an answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_mention', 'mentioned you on a question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'verified_purchase', 'Verified Purchase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_reviews_found', 'No reviews found');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_anonymously', 'Ask anonymously');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'ask_friend', 'Ask friend');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_for_friends', 'Search for friends');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'askfm_box_placeholder', 'What, when, why??? ask');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'question_can_not_empty', 'Question is required.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_who_you_want_ask', 'Please select who you want to ask');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'asked_you_a_question', 'asked you a question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_questions', 'Trending Questions');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_question', 'People liked this question');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'users_liked_answer', 'People liked this answer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_answers_found', 'No answers to show');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_header_people', 'Search for people and #hashtags');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'questions', 'Questions');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tweets', 'Tweets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'trending_tweets', 'Trending Tweets');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'people_liked_tweet', 'People liked this tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'liked_tweet', 'liked your tweet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_a_file_to_upload', 'Please select a file to upload');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'unlock_content_post_text', 'Unlock this content by becoming a patron');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'join_now', 'Join now');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patreon_membership_price', 'Patreon membership price');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience', 'Experience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_experience', 'Add New Experience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name', 'Company name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type', 'Employment type');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'full_time', 'Full time');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'part_time', 'Part time');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'self_employed', 'Self employed');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'freelance', 'Freelance');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contract', 'Contract');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'internship', 'Internship');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'apprenticeship', 'Apprenticeship');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'seasonal', 'Seasonal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry', 'Industry');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'title_empty', 'Please enter a title');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'company_name_empty', 'Please enter a company name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'employment_type_empty', 'Please enter a employment type');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'location_empty', 'Please enter a location');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'start_date_empty', 'Please enter a start date');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'industry_empty', 'Please enter an industry');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'description_empty', 'Please enter a description');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_choose_correct_experience_date', 'Please choose a correct date.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_created', 'Experience successfully created.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'valid_link', 'Please enter a valid link');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_experience', 'Delete your experience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_experience', 'Are you sure you want to delete this experience?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_experience', 'Edit experience');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_not_owner', 'You are not the owner, you can apply this action.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'experience_successfully_updated', 'Experience successfully updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certifications', 'Certifications');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'licenses_certifications', 'Licenses & Certificates');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_certification', 'Add New Certificate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization', 'Issuing organization');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_id', 'Credential ID');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'credential_url', 'Credential URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issuing_organization_empty', 'Please enter an issuing organization');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date', 'Issue date');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'expiration_date', 'Expiration date');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'issue_date_empty', 'Please enter the issuing date.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'name_empty', 'Please enter a name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_created', 'Your certificate has been created.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_certification', 'Delete your certificate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_certification', 'Are you sure you want to delete this certificate?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_certification', 'Edit Certificate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_successfully_updated', 'Your certificate has been updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'projects', 'Projects');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_new_project', 'Add new project');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_name', 'Project name');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'associated_with', 'Associated with');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_url', 'Project URL');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_added', 'Your project has been added.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_project', 'Delete your project');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_project', 'Are you sure you want to delete this project?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_project', 'Edit Project');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'project_successfully_updated', 'Your project has been updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'skills', 'Skills');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'languages', 'Languages');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to', 'Open To');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'finding_a_job', 'Finding a new job');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'providing_services', 'Providing services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hiring', 'Hiring');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_job_preferences', 'Add job preferences');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tell_us_kind_work', 'Tell us what kind of work you???re open to');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces', 'Workplaces');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_title', 'Job titles');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'on_site', 'On site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'hybrid', 'Hybrid');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remote', 'Remote');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_types', 'Job types');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'temporary', 'Temporary');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location', 'Job location');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Job_title_empty', 'Job title can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_location_empty', 'Job location can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'workplaces_empty', 'Please select a workplace');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_type_empty', 'Please select a job type');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_saved_successfully', 'Job preferences have been updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work', 'Open to work');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'see_all_details', 'See all details');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences', 'Job preferences');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'set_up_services_page', 'Let???s set up your services page');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services', 'Services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_empty', 'Services can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_saved_successfully', 'Services have been saved.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_provided', 'Services provided');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'invalid_id', 'Invalid id');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_edited_successfully', 'Services have been updated.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_job_preferences', 'Edit job preferences');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'job_preferences_edited_successfully', 'Job preferences have been edited.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'load_more_services', 'Load more services');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tiers', 'Tiers');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'choose_offer_patrons', 'Choose what to offer your patrons');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'add_tier', 'Add tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_title', 'Tier title');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_price', 'Tier price');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_image', 'Tier image');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_description', 'Tier description');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits', 'Benefits');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_video', 'Chat without audio and video call');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_without_video', 'Chat with audio call and without video call');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_without_audio_with_video', 'Chat without audio call and with video call');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat_with_audio_video', 'Chat with audio and video call');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'chat', 'Chat');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'live_stream', 'Live Stream');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'price_empty', 'Price can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'benefits_empty', 'Benefits can not be empty');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_select_chat_type', 'Please select the chat type');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_added_successfully', 'Tier successfully added');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'edit_tier', 'Edit tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'tier_updated_successfully', 'Tier successfully updated');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'delete_your_tier', 'Delete your tier');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_your_tier', 'Are you sure you want to delete this tier?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patron', 'Patron');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'patrons', 'Patrons');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'services_you_may_know', 'Services you may like');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'open_to_work_posts', 'Open to work posts');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Afrikaans_af', 'Afrikaans');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Albanian_sq', 'Albanian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Amharic_am', 'Amharic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Arabic_ar', 'Arabic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Aragonese_an', 'Aragonese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Armenian_hy', 'Armenian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Asturian_ast', 'Asturian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Azerbaijani_az', 'Azerbaijani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Basque_eu', 'Basque');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Belarusian_be', 'Belarusian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bengali_bn', 'Bengali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bosnian_bs', 'Bosnian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Breton_br', 'Breton');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Bulgarian_bg', 'Bulgarian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Catalan_ca', 'Catalan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Central Kurdish_ckb', 'Central Kurdish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Chinese_zh', 'Chinese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Corsican_co', 'Corsican');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Croatian_hr', 'Croatian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Czech_cs', 'Czech');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Danish_da', 'Danish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Dutch_nl', 'Dutch');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'English_en', 'English');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Esperanto_eo', 'Esperanto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Estonian_et', 'Estonian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Faroese_fo', 'Faroese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Filipino_fil', 'Filipino');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Finnish_fi', 'Finnish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'French_fr', 'French');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Galician_gl', 'Galician');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Georgian_ka', 'Georgian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'German_de', 'German');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Greek_el', 'Greek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Guarani_gn', 'Guarani');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Gujarati_gu', 'Gujarati');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hausa_ha', 'Hausa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hawaiian_haw', 'Hawaiian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hebrew_he', 'Hebrew');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hindi_hi', 'Hindi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Hungarian_hu', 'Hungarian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Icelandic_is', 'Icelandic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Indonesian_id', 'Indonesian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Interlingua_ia', 'Interlingua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Irish_ga', 'Irish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Italian_it', 'Italian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Japanese_ja', 'Japanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kannada_kn', 'Kannada');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kazakh_kk', 'Kazakh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Khmer_km', 'Khmer');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Korean_ko', 'Korean');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kurdish_ku', 'Kurdish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Kyrgyz_ky', 'Kyrgyz');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lao_lo', 'Lao');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latin_la', 'Latin');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Latvian_lv', 'Latvian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lingala_ln', 'Lingala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Lithuanian_lt', 'Lithuanian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Macedonian_mk', 'Macedonian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malay_ms', 'Malay');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Malayalam_ml', 'Malayalam');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Maltese_mt', 'Maltese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Marathi_mr', 'Marathi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Mongolian_mn', 'Mongolian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Nepali_ne', 'Nepali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian_no', 'Norwegian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Bokm??l_nb', 'Norwegian Bokm??l');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Norwegian Nynorsk_nn', 'Norwegian Nynorsk');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Occitan_oc', 'Occitan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oriya_or', 'Oriya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Oromo_om', 'Oromo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Pashto_ps', 'Pashto');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Persian_fa', 'Persian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Polish_pl', 'Polish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Portuguese_pt', 'Portuguese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Punjabi_pa', 'Punjabi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Quechua_qu', 'Quechua');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romanian_ro', 'Romanian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Romansh_rm', 'Romansh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Russian_ru', 'Russian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Scottish Gaelic_gd', 'Scottish Gaelic');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbian_sr', 'Serbian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Serbo_sh', 'Serbo');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Shona_sn', 'Shona');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sindhi_sd', 'Sindhi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sinhala_si', 'Sinhala');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovak_sk', 'Slovak');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Slovenian_sl', 'Slovenian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Somali_so', 'Somali');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Southern Sotho_st', 'Southern Sotho');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Spanish_es', 'Spanish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Sundanese_su', 'Sundanese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swahili_sw', 'Swahili');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Swedish_sv', 'Swedish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tajik_tg', 'Tajik');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tamil_ta', 'Tamil');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tatar_tt', 'Tatar');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Telugu_te', 'Telugu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Thai_th', 'Thai');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tigrinya_ti', 'Tigrinya');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Tongan_to', 'Tongan');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkish_tr', 'Turkish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Turkmen_tk', 'Turkmen');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Twi_tw', 'Twi');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Ukrainian_uk', 'Ukrainian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Urdu_ur', 'Urdu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uyghur_ug', 'Uyghur');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Uzbek_uz', 'Uzbek');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Vietnamese_vi', 'Vietnamese');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Walloon_wa', 'Walloon');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Welsh_cy', 'Welsh');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Western Frisian_fy', 'Western Frisian');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Xhosa_xh', 'Xhosa');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yiddish_yi', 'Yiddish');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Yoruba_yo', 'Yoruba');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'Zulu_zu', 'Zulu');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'no_available_data', 'No available data to show.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'my_wallet_', 'My Wallet');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'you_have_bought_products', 'You have bought a product');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sale_products', 'Sale products');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'entire_site', 'Entire Site');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'banned_for_violating', 'You were banned for violating our terms of use. Please {contact_us} for more details.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'were_banned_from', 'Oops, You were banned from {site_name}');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'contact_us_more_details', 'Please {contact_us} for more details.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'pdf_file', 'Attach PDF File');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'certification_file', 'Certificate');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_currently_working', 'Are you currently working?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_to_work', 'No I am looking to work');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'am_looking_for_employees', 'Yes I am looking for employees');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'products_for_sale', 'Products for sale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_notifications_because_you_were_banned', 'You can\'t view your notifications because you were banned');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_messages_because_you_were_banned', 'You can\'t view your messages because you were banned');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'your_requests_because_you_were_banned', 'You can\'t view your requests because you were banned');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'withdrawal', 'Withdrawal');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'successfully_received_from', 'Money was successfully received from');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'terms_of_use_page', '<h4>1- Write your Terms Of Use here.</h4>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.          <br><br>          <h4>2- Random title</h4>          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'privacy_policy_page', '<h2>Who we are?</h2>
      Provide name and contact details of the data controller. This will typically be your business or you, if you are a sole trader. Where applicable, you should include the identity and contact details of the controller???s representative and/or the data protection officer.

      <h2>What information do we collect?</h2>
      Specify the types of personal information you collect, eg names, addresses, user names, etc. You should include specific details on:
      how you collect data (eg when a user registers, purchases or uses your services, completes a contact form, signs up to a newsletter, etc)
      what specific data you collect through each of the data collection method
      if you collect data from third parties, you must specify categories of data and source
      if you process sensitive personal data or financial information, and how you handle this
      <br><br>
      You may want to provide the user with relevant definitions in relation to personal data and sensitive personal data.
      <br><br>
      <h2>How do we use personal information?</h2>
      Describe in detail all the service- and business-related purposes for which you will process data. For example, this may include things like:
      personalisation of content, business information or user experience
      account set up and administration
      delivering marketing and events communication
      carrying out polls and surveys
      internal research and development purposes
      providing goods and services
      legal obligations (eg prevention of fraud)
      meeting internal audit requirements
      <br><br>
      Please note this list is not exhaustive. You will need to record all purposes for which you process personal data.
      <br><br>
      <h2>What legal basis do we have for processing your personal data?</h2>
      Describe the relevant processing conditions contained within the GDPR. There are six possible legal grounds:
      consent
      contract
      legitimate interests
      vital interests
      public task
      legal obligation
      <br><br>
      Provide detailed information on all grounds that apply to your processing, and why. If you rely on consent, explain how individuals can withdraw and manage their consent. If you rely on legitimate interests, explain clearly what these are.
      <br><br>
      If you???re processing special category personal data, you will have to satisfy at least one of the six processing conditions, as well as additional requirements for processing under the GDPR. Provide information on all additional grounds that apply.
      <br><br>
      <h2>When do we share personal data?</h2>
      Explain that you will treat personal data confidentially and describe the circumstances when you might disclose or share it. Eg, when necessary to provide your services or conduct your business operations, as outlined in your purposes for processing. You should provide information on:
      how you will share the data
      what safeguards you will have in place
      what parties you may share the data with and why

      <h2>Where do we store and process personal data?</h2>
      If applicable, explain if you intend to store and process data outside of the data subject???s home country. Outline the steps you will take to ensure the data is processed according to your privacy policy and the applicable law of the country where data is located.

      If you transfer data outside the European Economic Area, outline the measures you will put in place to provide an appropriate level of data privacy protection. Eg contractual clauses, data transfer agreements, etc.

      <h2>How do we secure personal data?</h2>
      Describe your approach to data security and the technologies and procedures you use to protect personal information. For example, these may be measures:
      to protect data against accidental loss
      to prevent unauthorised access, use, destruction or disclosure
      to ensure business continuity and disaster recovery
      to restrict access to personal information
      to conduct privacy impact assessments in accordance with the law and your business policies
      to train staff and contractors on data security
      to manage third party risks, through use of contracts and security reviews
      <br><br>
      Please note this list is not exhaustive. You should record all mechanisms you rely on to protect personal data. You should also state if your organisation adheres to certain accepted standards or regulatory requirements.
      <br><br>
      <h2>How long do we keep your personal data for?</h2>
      Provide specific information on the length of time you will keep the information for in relation to each processing purpose. The GDPR requires you to retain data for no longer than reasonably necessary. Include details of your data or records retention schedules, or link to additional resources where these are published.
      <br><br>
      If you cannot state a specific period, you need to set out the criteria you will apply to determine how long to keep the data for (eg local laws, contractual obligations, etc)
      <br><br>
      You should also outline how you securely dispose of data after you no longer need it.
      <br><br>
      <h2>Your rights in relation to personal data</h2>
      Under the GDPR, you must respect the right of data subjects to access and control their personal data. In your privacy notice, you must outline their rights in respect of:
      access to personal information
      correction and deletion
      withdrawal of consent (if processing data on condition of consent)
      data portability
      restriction of processing and objection
      lodging a complaint with the Information Commissioner???s Office

      You should explain how individuals can exercise their rights, and how you plan to respond to subject data requests. State if any relevant exemptions may apply and set out any identity verifications procedures you may rely on.

      Include details of the circumstances where data subject rights may be limited, eg if fulfilling the data subject request may expose personal data about another person, or if you???re asked to delete data which you are required to keep by law.

      <h2>Use of automated decision-making and profiling</h2>
      Where you use profiling or other automated decision-making, you must disclose this in your privacy policy. In such cases, you must provide details on existence of any automated decision-making, together with information about the logic involved, and the likely significance and consequences of the processing of the individual.

      <h2>How to contact us?</h2>
      Explain how data subject can get in touch if they have questions or concerns about your privacy practices, their personal information, or if they wish to file a complaint. Describe all ways in which they can contact you ??? eg online, by email or postal mail.
      <br><br>
      If applicable, you may also include information on:
      <br><br>
      <h2>Use of cookies and other technologies</h2>
      You may include a link to further information, or describe within the policy if you intend to set and use cookies, tracking and similar technologies to store and manage user preferences on your website, advertise, enable content or otherwise analyse user and usage data. Provide information on what types of cookies and technologies you use, why you use them and how an individual can control and manage them.
      <br><br>
      Linking to other websites / third party content
      If you link to external sites and resources from your website, be specific on whether this constitutes endorsement, and if you take any responsibility for the content (or information contained within) any linked website.
      <br><br>
      You may wish to consider adding other optional clauses to your privacy policy, depending on your business??? circumstances.
      ');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'about_page', '<h4>1- Write about your website here.</h4>          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.          <br><br>          <h4>2- Random title</h4>          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dxzcolore magna aliqua. Ut enim ad minim veniam,          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'refund_terms_page', '<h4>1- Write your Terms Of Use here.</h4>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.          <br><br>          <h4>2- Random title</h4>          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'added_review_to_your_product', 'reviewed your product');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'coinbase', 'Coinbase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'product_purchase', 'Product Purchase');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'sold_a_product', 'Product Sale');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'describe_your_review', 'Describe your review here..');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'related_prods', 'Related Products');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_open_work', 'Are you sure you want to delete?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'are_you_delete_services', 'Are you sure you want to delete these services?');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'search_find_job_at', 'Search, find and apply to job opportunities at');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'connect_with_friends', 'Connect with friends!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'login_connect_friends', 'Login into your {site_name} account and connect with your friends!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'remember_device', 'Remember this device');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'register_create_account', 'Create your {site_name} Account!');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'please_upgrade_to_upload', 'Just Pro users can upload Please upgrade to pro');
          $lang_update_queries[] = Wo_UpdateLangs($value, 'type_something_to_post', 'Your post content can\'t be empty.');
        }
    }
    if (!empty($lang_update_queries)) {
        foreach ($lang_update_queries as $key => $query) {
            $sql = mysqli_query($sqlConnect, $query);
        }
        foreach ($wo['config']['currency_symbol_array'] as $key => $value) {
        	if ($key == 'USD') {
        		$wo['config']['currency_symbol_array'][$key] = '$';
        	}
        	if ($key == 'EUR') {
        		$wo['config']['currency_symbol_array'][$key] = '???';
        	}
        	if ($key == 'JPY') {
        		$wo['config']['currency_symbol_array'][$key] = '??';
        	}
        	if ($key == 'TRY') {
        		$wo['config']['currency_symbol_array'][$key] = '???';
        	}
        	if ($key == 'GBP') {
        		$wo['config']['currency_symbol_array'][$key] = '??';
        	}
        	if ($key == 'RUB') {
        		$wo['config']['currency_symbol_array'][$key] = '???';
        	}
        	if ($key == 'PLN') {
        		$wo['config']['currency_symbol_array'][$key] = 'z??';
        	}
        	if ($key == 'ILS') {
        		$wo['config']['currency_symbol_array'][$key] = '???';
        	}
        	if ($key == 'BRL') {
        		$wo['config']['currency_symbol_array'][$key] = 'R$';
        	}
        	if ($key == 'INR') {
        		$wo['config']['currency_symbol_array'][$key] = '???';
        	}
        }
        if (empty($wo['config']['currency_symbol_array']['JPY'])) {
        	$wo['config']['currency_symbol_array']['JPY'] = '??';
        }
        Wo_SaveConfig('currency_symbol_array', json_encode($wo['config']['currency_symbol_array']));
    }
    if (!is_writable("./sources/server.php")) {
        @chmod("./sources/server.php", 0777);
    }
    $name = md5(microtime()) . '_updated.php';
    rename('update.php', $name);
}
?>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1"/>
      <title>Updating WoWonder</title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <style>
         @import url('https://fonts.googleapis.com/css?family=Roboto:400,500');
         @media print {
            .wo_update_changelog {max-height: none !important; min-height: !important}
            .btn, .hide_print, .setting-well h4 {display:none;}
         }
         * {outline: none !important;}
         body {background: #f3f3f3;font-family: 'Roboto', sans-serif;}
         .light {font-weight: 400;}
         .bold {font-weight: 500;}
         .btn {height: 52px;line-height: 1;font-size: 16px;transition: all 0.3s;border-radius: 2em;font-weight: 500;padding: 0 28px;letter-spacing: .5px;}
         .btn svg {margin-left: 10px;margin-top: -2px;transition: all 0.3s;vertical-align: middle;}
         .btn:hover svg {-webkit-transform: translateX(3px);-moz-transform: translateX(3px);-ms-transform: translateX(3px);-o-transform: translateX(3px);transform: translateX(3px);}
         .btn-main {color: #ffffff;background-color: #a84849;border-color: #a84849;}
         .btn-main:disabled, .btn-main:focus {color: #fff;}
         .btn-main:hover {color: #ffffff;background-color: #c45a5b;border-color: #c45a5b;box-shadow: -2px 2px 14px rgba(168, 72, 73, 0.35);}
         svg {vertical-align: middle;}
         .main {color: #a84849;}
         .wo_update_changelog {
          border: 1px solid #eee;
          padding: 10px !important;
         }
         .content-container {display: -webkit-box; width: 100%;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-flex-direction: column;flex-direction: column;min-height: 100vh;position: relative;}
         .content-container:before, .content-container:after {-webkit-box-flex: 1;box-flex: 1;-webkit-flex-grow: 1;flex-grow: 1;content: '';display: block;height: 50px;}
         .wo_install_wiz {position: relative;background-color: white;box-shadow: 0 1px 15px 2px rgba(0, 0, 0, 0.1);border-radius: 10px;padding: 20px 30px;border-top: 1px solid rgba(0, 0, 0, 0.04);}
         .wo_install_wiz h2 {margin-top: 10px;margin-bottom: 30px;display: flex;align-items: center;}
         .wo_install_wiz h2 span {margin-left: auto;font-size: 15px;}
         .wo_update_changelog {padding:0;list-style-type: none;margin-bottom: 15px;max-height: 440px;overflow-y: auto; min-height: 440px;}
         .wo_update_changelog li {margin-bottom:7px; max-height: 20px; overflow: hidden;}
         .wo_update_changelog li span {padding: 2px 7px;font-size: 12px;margin-right: 4px;border-radius: 2px;}
         .wo_update_changelog li span.added {background-color: #4CAF50;color: white;}
         .wo_update_changelog li span.changed {background-color: #e62117;color: white;}
         .wo_update_changelog li span.improved {background-color: #9C27B0;color: white;}
         .wo_update_changelog li span.compressed {background-color: #795548;color: white;}
         .wo_update_changelog li span.fixed {background-color: #2196F3;color: white;}
         input.form-control {background-color: #f4f4f4;border: 0;border-radius: 2em;height: 40px;padding: 3px 14px;color: #383838;transition: all 0.2s;}
input.form-control:hover {background-color: #e9e9e9;}
input.form-control:focus {background: #fff;box-shadow: 0 0 0 1.5px #a84849;}
         .empty_state {margin-top: 80px;margin-bottom: 80px;font-weight: 500;color: #6d6d6d;display: block;text-align: center;}
         .checkmark__circle {stroke-dasharray: 166;stroke-dashoffset: 166;stroke-width: 2;stroke-miterlimit: 10;stroke: #7ac142;fill: none;animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;}
         .checkmark {width: 80px;height: 80px; border-radius: 50%;display: block;stroke-width: 3;stroke: #fff;stroke-miterlimit: 10;margin: 100px auto 50px;box-shadow: inset 0px 0px 0px #7ac142;animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;}
         .checkmark__check {transform-origin: 50% 50%;stroke-dasharray: 48;stroke-dashoffset: 48;animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;}
         @keyframes stroke { 100% {stroke-dashoffset: 0;}}
         @keyframes scale {0%, 100% {transform: none;}  50% {transform: scale3d(1.1, 1.1, 1); }}
         @keyframes fill { 100% {box-shadow: inset 0px 0px 0px 54px #7ac142; }}
      </style>
   </head>
   <body>
      <div class="content-container container">
         <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
               <div class="wo_install_wiz">
                 <?php if ($updated == false) { ?>
                  <div>
                     <h2 class="light">Update to v4.0</span></h2>
                     <div class="setting-well">
                        <h4>Changelog</h4>
                        <ul class="wo_update_changelog">
                        <li> [Added] website mode, switch your website instantly to Linkedin mode. (Instagram, Twitter, AskFM, Patreon are coming soon).</li>
                        <li> [Added] marketplace system, users can now buy and sell products + admin commission. </li>
                        <li> [Added] moderator rules manager, now you can choose what a moderator can do.</li>
                        <li> [Added] more ads placements (jobs, forums, movies, offers & funding) & entire site option.</li>
                        <li> [Added] multiple levels affiliate system.</li>
                        <li> [Added] custom ban message for every user. </li>
                        <li> [Added] the ability to translate terms pages.</li>
                        <li> [Added] CoinBase payment method. </li>
                        <li> [Added] new search system for Linkedin mode. </li>
                        <li> [Added] more APIs. </li>
                        <li> [Added] ReCaptcha to create article page. </li>
                        <li> [Added] Wasabi Storage.</li>
                        <li> [Added] new welcome page.</li>
                        <li> [Added] remember me on login page.</li>
                        <li> [Added] mutli languages support for terms, privacy and about pages.</li>
                        <li> [Updated] bulksms API.</li>
                        <li> [Updated] CoinPayments API.</li>
                        <li> [Updated] Infobip API.</li>
                        <li> [Updated] marketplace, jobs & movies pages design (default theme). </li>
                        <li> [Updated] desgin in a few other pages (default theme).</li>
                        <li> [Updated] Twilio SDK. </li>
                        <li> [Updated] left sidebar icons. (default theme)</li>
                        <li> [Updated] documentation & FAQs: <a href="https://docs.wowonder.com/" target="_blank">https://docs.wowonder.com/</a> .</li>
                        <li> [Cleaned] 10,000+ lines of outdated code. </li>
                        <li> [Orginzed] PHP code format (HTML coming in next update).</li>
                        <li> [Fixed] images with _small extensions is not getting deleted on remote storage.</li>
                        <li> [Fixed] watermark isn't working on images posts.</li>
                        <li> [Fixed] family memebers texts.</li>
                        <li> [Fixed] auto username, pages likes or groups joins isn't working when you register using the app.</li>
                        <li> [Fixed] login with instagram isn't working.</li>
                        <li> [Fixed] email notifications are not working on follow, view profile or comments.</li>
                        <li> [Fixed] digitalocean test button wasn't working in admin panel.</li>
                        <li> [Fixed] Audio/video calls are not working from website to apps using agora.</li>
                        <li> [Fixed] "common things" page php fatal error.</li>
                        <li> [Fixed] 2 XSS exploits. <small style="color: red;">[Important!]</small>  </li>
                        <li> [Fixed] blank page when adding / in url.</li>
                        <li> [Fixed] site-map doesn't generate more than 50K links.</li>
                        <li> [Fixed] read more button on mobile.</li>
                        <li> [Fixed] 30+ more minor bugs.</li>
                        <li> [Fixed] bugs in API.</li>
                        </ul>
                        <p class="hide_print">Note: The update process might take few minutes.</p>
                        <p class="hide_print">Important: If you got any fail queries, please copy them, open a support ticket and send us the details.</p>
                        <p class="hide_print">Most of the features are disabled by default, you can enable them from Admin -> Manage Features -> Enable / Disable Features, reaction can be enabled from Settings > Posts Sttings.</p><br>
                        <p class="hide_print">Please enter your valid purchase code:</p>
                        <input type="text" id="input_code" class="form-control" placeholder="Your Envato purchase code" style="padding: 10px; width: 50%;"><br>

                        <br>
                             <button class="pull-right btn btn-default" onclick="window.print();">Share Log</button>
                             <button type="button" class="btn btn-main" id="button-update" disabled>
                             Update
                             <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                <path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path>
                             </svg>
                          </button>
                     </div>
                     <?php }?>
                     <?php if ($updated == true) { ?>
                      <div>
                        <div class="empty_state">
                           <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                           </svg>
                           <p>Congratulations, you have successfully updated your site. Thanks for choosing WoWonder.</p>
                           <br>
                           <a href="<?php echo $wo['config']['site_url'] ?>" class="btn btn-main" style="line-height:50px;">Home</a>
                        </div>
                     </div>
                     <?php }?>
                  </div>
               </div>
            </div>
            <div class="col-md-1"></div>
         </div>
      </div>
   </body>
</html>
<script>
var queries = [
    "UPDATE `Wo_Config` SET `value` = '4.0' WHERE `name` = 'version';",
    "ALTER TABLE `Wo_Manage_Pro` CHANGE `time` `time` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'week';",
    "UPDATE `Wo_Manage_Pro` SET `time` = 'week' WHERE `Wo_Manage_Pro`.`id` = 1;",
    "UPDATE `Wo_Manage_Pro` SET `time` = 'month' WHERE `Wo_Manage_Pro`.`id` = 2;",
    "UPDATE `Wo_Manage_Pro` SET `time` = 'year' WHERE `Wo_Manage_Pro`.`id` = 3;",
    "UPDATE `Wo_Manage_Pro` SET `time` = 'unlimited' WHERE `Wo_Manage_Pro`.`id` = 4;",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'msg91_dlt_id', '');",
    "ALTER TABLE `Wo_Users` ADD `permission` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `time_code_sent`;",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'store_system', 'on');",
    "CREATE TABLE `Wo_UserCard` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL DEFAULT 0,  `product_id` int(11) NOT NULL DEFAULT 0,  `units` int(11) NOT NULL DEFAULT 0,  PRIMARY KEY (`id`),  KEY `user_id` (`user_id`),  KEY `product_id` (`product_id`),  KEY `units` (`units`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `Wo_Products` ADD `units` INT(11) NOT NULL DEFAULT '0' AFTER `lat`, ADD INDEX (`units`);",
    "CREATE TABLE `Wo_UserAddress` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL DEFAULT 0,  `name` varchar(100) NOT NULL DEFAULT '',  `phone` varchar(50) NOT NULL DEFAULT '',  `country` varchar(100) NOT NULL DEFAULT '',  `city` varchar(100) NOT NULL DEFAULT '',  `zip` varchar(20) NOT NULL DEFAULT '',  `address` varchar(500) NOT NULL DEFAULT '',  `time` int(11) NOT NULL DEFAULT 0,  PRIMARY KEY (`id`),  KEY `user_id` (`user_id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'exchange', '');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'exchange_update', '');",
    "UPDATE `Wo_Config` SET `value` = '{\"USD\":\"&#36;\",\"EUR\":\"&#8364;\",\"JPY\":\"&#165;\",\"TRY\":\"&#8378;\",\"GBP\":\"&#163;\",\"RUB\":\"&#8381;\",\"PLN\":\"&#122;&#322;\",\"ILS\":\"&#8362;\",\"BRL\":\"&#82;&#36;\",\"INR\":\"&#8377;\"}' WHERE `Wo_Config`.`name` = 'currency_symbol_array';",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'store_commission', '0');",
    "CREATE TABLE `Wo_UserOrders` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `hash_id` varchar(100) NOT NULL DEFAULT '',  `user_id` int(11) NOT NULL DEFAULT 0,  `product_owner_id` int(11) NOT NULL DEFAULT 0,  `product_id` int(11) NOT NULL DEFAULT 0,  `address_id` int(11) NOT NULL DEFAULT 0,  `price` float NOT NULL DEFAULT 0,  `commission` float NOT NULL DEFAULT 0,  `final_price` float NOT NULL DEFAULT 0,  `units` int(11) NOT NULL DEFAULT 0,  `tracking_url` varchar(500) NOT NULL DEFAULT '',  `tracking_id` varchar(50) NOT NULL DEFAULT '',  `status` varchar(30) NOT NULL DEFAULT 'placed',  `time` int(11) NOT NULL DEFAULT 0,  PRIMARY KEY (`id`),  KEY `user_id` (`user_id`),  KEY `product_owner_id` (`product_owner_id`),  KEY `product_id` (`product_id`),  KEY `final_price` (`final_price`),  KEY `status` (`status`),  KEY `time` (`time`),  KEY `hash_id` (`hash_id`),  KEY `units` (`units`),  KEY `address_id` (`address_id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "CREATE TABLE `Wo_Purchases` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL DEFAULT 0,  `order_hash_id` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',  `owner_id` int(11) NOT NULL DEFAULT 0,  `data` text CHARACTER SET utf8 DEFAULT NULL,  `final_price` float NOT NULL DEFAULT 0,  `commission` float NOT NULL DEFAULT 0,  `price` float NOT NULL DEFAULT 0,  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),  `time` int(11) NOT NULL DEFAULT 0,  PRIMARY KEY (`id`),  KEY `user_id` (`user_id`),  KEY `timestamp` (`timestamp`),  KEY `time` (`time`),  KEY `owner_id` (`owner_id`),  KEY `final_price` (`final_price`),  KEY `order_hash_id` (`order_hash_id`),  KEY `data` (`data`(1024))) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;",
    "CREATE TABLE `Wo_ProductReview` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `user_id` int(11) NOT NULL DEFAULT 0,  `product_id` int(11) NOT NULL DEFAULT 0,  `review` text DEFAULT NULL,  `star` int(11) NOT NULL DEFAULT 1,  `time` int(11) NOT NULL DEFAULT 0,  PRIMARY KEY (`id`),  KEY `user_id` (`user_id`),  KEY `product_id` (`product_id`),  KEY `star` (`star`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;",
    "ALTER TABLE `Wo_Refund` ADD `order_hash_id` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `user_id`;",
    "ALTER TABLE `Wo_Albums_Media` ADD `review_id` INT(11) NOT NULL DEFAULT '0' AFTER `parent_id`, ADD INDEX (`review_id`);",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'store_review_system', 'off');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'website_mode', 'facebook');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'post_location', '1');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'post_feelings', '1');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'post_poll', '1');",
    "CREATE TABLE `Wo_PatreonSubscribers` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `subscriber_id` INT(11) NOT NULL DEFAULT '0' , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`subscriber_id`), INDEX (`time`)) ENGINE = InnoDB;",
    "CREATE TABLE `Wo_UserExperience` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `title` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `location` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `experience_start` DATE NOT NULL , `experience_end` DATE NOT NULL , `industry` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL , `image` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `link` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `headline` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `company_name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `employment_type` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`time`)) ENGINE = InnoDB;",
    "CREATE TABLE `Wo_UserCertification` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `issuing_organization` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `credential_id` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `credential_url` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `certification_start` DATE NOT NULL , `certification_end` DATE NOT NULL , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`)) ENGINE = InnoDB;",
    "CREATE TABLE `Wo_UserProjects` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `description` VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `associated_with` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `project_url` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `project_start` DATE NOT NULL , `project_end` DATE NOT NULL , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`name`)) ENGINE = InnoDB;",
    "ALTER TABLE `Wo_Users` ADD `skills` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `permission`;",
    "ALTER TABLE `Wo_Users` ADD `languages` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `skills`;",
    "CREATE TABLE `Wo_UserOpenTo` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `job_title` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `job_location` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `workplaces` VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `job_type` VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `type` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`job_title`), INDEX (`job_location`), INDEX (`workplaces`), INDEX (`job_type`), INDEX (`type`), INDEX (`time`)) ENGINE = InnoDB;",
    "ALTER TABLE `Wo_UserOpenTo` ADD `services` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `job_type`, ADD `description` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `services`, ADD INDEX (`services`), ADD INDEX (`description`);",
    "CREATE TABLE `Wo_UserTiers` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `title` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `price` FLOAT(11) NOT NULL DEFAULT '0' , `image` VARCHAR(400) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `description` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `chat` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , `live_stream` INT(11) NOT NULL DEFAULT '0' , `time` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), INDEX (`user_id`), INDEX (`chat`), INDEX (`live_stream`)) ENGINE = InnoDB;",
    "ALTER TABLE `Wo_Posts` CHANGE `postPrivacy` `postPrivacy` ENUM('0','1','2','3','4','5') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1';",
    "CREATE TABLE `Wo_UserSkills` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , PRIMARY KEY (`id`), INDEX (`name`)) ENGINE = InnoDB;",
    "CREATE TABLE `Wo_UserLanguages` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `lang_key` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' , PRIMARY KEY (`id`), INDEX (`lang_key`)) ENGINE = InnoDB;",
    "INSERT INTO `Wo_UserLanguages` (`id`, `lang_key`) VALUES (NULL, 'Afrikaans_af'),(NULL, 'Albanian_sq'),(NULL, 'Amharic_am'),(NULL, 'Arabic_ar'),(NULL, 'Aragonese_an'),(NULL, 'Armenian_hy'),(NULL, 'Asturian_ast'),(NULL, 'Azerbaijani_az'),(NULL, 'Basque_eu'),(NULL, 'Belarusian_be'),(NULL, 'Bengali_bn'),(NULL, 'Bosnian_bs'),(NULL, 'Breton_br'),(NULL, 'Bulgarian_bg'),(NULL, 'Catalan_ca'),(NULL, 'Central Kurdish_ckb'),(NULL, 'Chinese_zh'),(NULL, 'Corsican_co'),(NULL, 'Croatian_hr'),(NULL, 'Czech_cs'),(NULL, 'Danish_da'),(NULL, 'Dutch_nl'),(NULL, 'English_en'),(NULL, 'Esperanto_eo'),(NULL, 'Estonian_et'),(NULL, 'Faroese_fo'),(NULL, 'Filipino_fil'),(NULL, 'Finnish_fi'),(NULL, 'French_fr'),(NULL, 'Galician_gl'),(NULL, 'Georgian_ka'),(NULL, 'German_de'),(NULL, 'Greek_el'),(NULL, 'Guarani_gn'),(NULL, 'Gujarati_gu'),(NULL, 'Hausa_ha'),(NULL, 'Hawaiian_haw'),(NULL, 'Hebrew_he'),(NULL, 'Hindi_hi'),(NULL, 'Hungarian_hu'),(NULL, 'Icelandic_is'),(NULL, 'Indonesian_id'),(NULL, 'Interlingua_ia'),(NULL, 'Irish_ga'),(NULL, 'Italian_it'),(NULL, 'Japanese_ja'),(NULL, 'Kannada_kn'),(NULL, 'Kazakh_kk'),(NULL, 'Khmer_km'),(NULL, 'Korean_ko'),(NULL, 'Kurdish_ku'),(NULL, 'Kyrgyz_ky'),(NULL, 'Lao_lo'),(NULL, 'Latin_la'),(NULL, 'Latvian_lv'),(NULL, 'Lingala_ln'),(NULL, 'Lithuanian_lt'),(NULL, 'Macedonian_mk'),(NULL, 'Malay_ms'),(NULL, 'Malayalam_ml'),(NULL, 'Maltese_mt'),(NULL, 'Marathi_mr'),(NULL, 'Mongolian_mn'),(NULL, 'Nepali_ne'),(NULL, 'Norwegian_no'),(NULL, 'Norwegian Bokm??l_nb'),(NULL, 'Norwegian Nynorsk_nn'),(NULL, 'Occitan_oc'),(NULL, 'Oriya_or'),(NULL, 'Oromo_om'),(NULL, 'Pashto_ps'),(NULL, 'Persian_fa'),(NULL, 'Polish_pl'),(NULL, 'Portuguese_pt'),(NULL, 'Punjabi_pa'),(NULL, 'Quechua_qu'),(NULL, 'Romanian_ro'),(NULL, 'Romansh_rm'),(NULL, 'Russian_ru'),(NULL, 'Scottish Gaelic_gd'),(NULL, 'Serbian_sr'),(NULL, 'Serbo_sh'),(NULL, 'Shona_sn'),(NULL, 'Sindhi_sd'),(NULL, 'Sinhala_si'),(NULL, 'Slovak_sk'),(NULL, 'Slovenian_sl'),(NULL, 'Somali_so'),(NULL, 'Southern Sotho_st'),(NULL, 'Spanish_es'),(NULL, 'Sundanese_su'),(NULL, 'Swahili_sw'),(NULL, 'Swedish_sv'),(NULL, 'Tajik_tg'),(NULL, 'Tamil_ta'),(NULL, 'Tatar_tt'),(NULL, 'Telugu_te'),(NULL, 'Thai_th'),(NULL, 'Tigrinya_ti'),(NULL, 'Tongan_to'),(NULL, 'Turkish_tr'),(NULL, 'Turkmen_tk'),(NULL, 'Twi_tw'),(NULL, 'Ukrainian_uk'),(NULL, 'Urdu_ur'),(NULL, 'Uyghur_ug'),(NULL, 'Uzbek_uz'),(NULL, 'Vietnamese_vi'),(NULL, 'Walloon_wa'),(NULL, 'Welsh_cy'),(NULL, 'Western Frisian_fy'),(NULL, 'Xhosa_xh'),(NULL, 'Yiddish_yi'),(NULL, 'Yoruba_yo'),(NULL, 'Zulu_zu');",
    "ALTER TABLE `Wo_Banned_Ip` ADD `reason` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `ip_address`;",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'affiliate_level', '1');",
    "ALTER TABLE `Wo_Users` ADD `ref_level` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `ref_user_id`;",
    "ALTER TABLE `Wo_UserCertification` ADD `pdf` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `certification_end`;",
    "ALTER TABLE `Wo_UserCertification` ADD `filename` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `pdf`;",
    "ALTER TABLE `Wo_Users` ADD `currently_working` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `languages`, ADD INDEX (`currently_working`);",
    "ALTER TABLE `Wo_Users` ADD `banned` INT(5) NOT NULL DEFAULT '0' AFTER `currently_working`, ADD INDEX (`banned`);",
    "ALTER TABLE `Wo_Users` ADD `banned_reason` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `banned`;",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'coinbase_payment', '0');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'coinbase_key', '');",
    "ALTER TABLE `Wo_Users` ADD `coinbase_hash` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `banned_reason`, ADD `coinbase_code` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `coinbase_hash`, ADD INDEX (`coinbase_hash`), ADD INDEX (`coinbase_code`);",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_storage', '0');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_access_key', '');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_secret_key', '');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_bucket_name', '');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'wasabi_bucket_region', 'us-west-1');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'remember_device', '1');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'infobip_api_key', '');",
    "INSERT INTO `Wo_Config` (`id`, `name`, `value`) VALUES (NULL, 'infobip_base_url', '');",
    "ALTER TABLE `Wo_Mute` CHANGE `archive` `archive` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no', CHANGE `pin` `pin` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no';",
    "ALTER TABLE `Wo_Messages` ADD `listening` INT(11) NOT NULL DEFAULT '0' AFTER `forward`, ADD INDEX (`listening`);",
    "DROP INDEX lang_key ON Wo_Langs;",
    "DROP INDEX name ON Wo_Config;",
    "ALTER IGNORE TABLE Wo_Langs ADD UNIQUE INDEX idx_name (lang_key);",
    "ALTER IGNORE TABLE Wo_Config ADD UNIQUE INDEX idx_name (name);",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'you_must_add_text_or_image_first');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'add_to_cart');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'remove_from_cart');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'pay_from_wallet');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_top_up_wallet');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'pay_to_upgrade');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'pay_to_fund');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'amount_can_not_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'fund_not_found');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'payment_successfully_done');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'buy_now');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'total_item');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'total_item_not_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'currently_unavailable');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'checkout');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'no_items_found');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'total');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'my_addresses');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'add_new');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'add_new_address');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'address_added');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'delete_your_address');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'are_you_delete_your_address');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'edit_address');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'address_edited');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_add_address');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_select_address');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'payment_alert');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'purchase_the_items');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'shopping_cart');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'items');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'back_to_shop');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'some_products_units');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'address_can_not_be_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'address_not_found');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'card_is_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'your_order_has_been_placed_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'purchased');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'no_purchased_found');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'order');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'download_invoice');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'id_can_not_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'you_are_not_purchased');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'order_not_found');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'order_details');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'write_review');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tracking_details');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'delivery_address');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'if_the_order_status');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'if_the_order_delivered');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'placed');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'payments');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'subtotal');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'sale_invoice');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'seller_name');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'seller_email');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'invoice_to');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'payment_details');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'total_due');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'bank_name');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'invoice');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'item');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'orders');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'no_orders_found');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'products');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'qty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'canceled');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'accepted');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'packed');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'shipped');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'commission');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'final_price');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tracking_number');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'link');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tracking_info_has_been_saved_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tracking_url_can_not_be_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tracking_number_can_not_be_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_enter_valid_url');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'site_url');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'delivered');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_explain_the_reason');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'your_request_is_under_review');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'review');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'submit');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'review_can_not_be_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'rating_can_not_be_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'review_has_been_sent_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'admin_status_changed');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'new_orders_has_been_placed');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'added_tracking_info');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'product_approved');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'your_product_is_under_review');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tweet');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'ask');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'write_answer');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'reply_to_answer');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'answered_your_question');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'replied_to_answer');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'liked_question');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'liked_answer');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'answer_mention');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'question_mention');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'verified_purchase');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'no_reviews_found');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'ask_anonymously');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'ask_friend');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'search_for_friends');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'askfm_box_placeholder');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'question_can_not_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_select_who_you_want_ask');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'asked_you_a_question');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'trending_questions');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'people_liked_question');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'users_liked_answer');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'no_answers_found');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'search_header_people');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tweets');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'trending_tweets');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'people_liked_tweet');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'liked_tweet');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_select_a_file_to_upload');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'unlock_content_post_text');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'join_now');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'patreon_membership_price');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'add_new_experience');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'company_name');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'employment_type');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'self_employed');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'freelance');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'apprenticeship');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'seasonal');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'industry');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'title_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'company_name_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'employment_type_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'location_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'start_date_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'industry_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'description_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_choose_correct_experience_date');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'experience_successfully_created');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'valid_link');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'delete_your_experience');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'are_you_delete_your_experience');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'edit_experience');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'you_not_owner');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'experience_successfully_updated');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'certifications');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'licenses_certifications');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'add_new_certification');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'issuing_organization');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'credential_id');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'credential_url');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'issuing_organization_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'issue_date');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'expiration_date');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'issue_date_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'name_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'certification_successfully_created');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'delete_your_certification');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'are_you_delete_your_certification');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'edit_certification');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'certification_successfully_updated');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'projects');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'add_new_project');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'project_name');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'associated_with');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'project_url');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'project_successfully_added');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'delete_your_project');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'are_you_delete_your_project');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'edit_project');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'project_successfully_updated');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'skills');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'languages');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'open_to');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'finding_a_job');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'providing_services');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'hiring');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'add_job_preferences');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tell_us_kind_work');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'workplaces');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'on_site');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'hybrid');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'remote');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'job_types');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'temporary');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'job_location');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Job_title_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'job_location_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'workplaces_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'job_type_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'job_preferences_saved_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'open_to_work');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'see_all_details');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'job_preferences');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'set_up_services_page');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'services');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'services_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'services_saved_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'services_provided');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'invalid_id');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'services_edited_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'edit_job_preferences');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'job_preferences_edited_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'load_more_services');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tiers');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'choose_offer_patrons');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'add_tier');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tier_title');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tier_price');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tier_image');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tier_description');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'benefits');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'chat_without_audio_video');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'chat_with_audio_without_video');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'chat_without_audio_with_video');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'chat_with_audio_video');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'chat');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'live_stream');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'price_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'benefits_empty');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_select_chat_type');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tier_added_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'edit_tier');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'tier_updated_successfully');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'delete_your_tier');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'are_you_delete_your_tier');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'patron');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'patrons');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'services_you_may_know');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'open_to_work_posts');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Afrikaans_af');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Albanian_sq');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Amharic_am');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Arabic_ar');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Aragonese_an');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Armenian_hy');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Asturian_ast');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Azerbaijani_az');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Basque_eu');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Belarusian_be');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Bengali_bn');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Bosnian_bs');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Breton_br');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Bulgarian_bg');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Catalan_ca');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Central Kurdish_ckb');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Chinese_zh');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Corsican_co');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Croatian_hr');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Czech_cs');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Danish_da');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Dutch_nl');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'English_en');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Esperanto_eo');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Estonian_et');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Faroese_fo');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Filipino_fil');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Finnish_fi');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'French_fr');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Galician_gl');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Georgian_ka');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'German_de');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Greek_el');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Guarani_gn');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Gujarati_gu');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Hausa_ha');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Hawaiian_haw');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Hebrew_he');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Hindi_hi');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Hungarian_hu');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Icelandic_is');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Indonesian_id');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Interlingua_ia');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Irish_ga');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Italian_it');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Japanese_ja');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Kannada_kn');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Kazakh_kk');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Khmer_km');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Korean_ko');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Kurdish_ku');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Kyrgyz_ky');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Lao_lo');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Latin_la');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Latvian_lv');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Lingala_ln');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Lithuanian_lt');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Macedonian_mk');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Malay_ms');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Malayalam_ml');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Maltese_mt');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Marathi_mr');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Mongolian_mn');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Nepali_ne');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Norwegian_no');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Norwegian Bokm??l_nb');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Norwegian Nynorsk_nn');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Occitan_oc');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Oriya_or');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Oromo_om');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Pashto_ps');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Persian_fa');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Polish_pl');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Portuguese_pt');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Punjabi_pa');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Quechua_qu');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Romanian_ro');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Romansh_rm');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Russian_ru');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Scottish Gaelic_gd');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Serbian_sr');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Serbo_sh');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Shona_sn');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Sindhi_sd');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Sinhala_si');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Slovak_sk');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Slovenian_sl');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Somali_so');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Southern Sotho_st');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Spanish_es');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Sundanese_su');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Swahili_sw');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Swedish_sv');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Tajik_tg');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Tamil_ta');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Tatar_tt');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Telugu_te');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Thai_th');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Tigrinya_ti');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Tongan_to');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Turkish_tr');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Turkmen_tk');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Twi_tw');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Ukrainian_uk');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Urdu_ur');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Uyghur_ug');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Uzbek_uz');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Vietnamese_vi');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Walloon_wa');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Welsh_cy');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Western Frisian_fy');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Xhosa_xh');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Yiddish_yi');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Yoruba_yo');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'Zulu_zu');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'no_available_data');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'my_wallet_');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'you_have_bought_products');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'sale_products');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'entire_site');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'banned_for_violating');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'were_banned_from');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'contact_us_more_details');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'pdf_file');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'certification_file');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'are_you_currently_working');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'am_looking_to_work');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'am_looking_for_employees');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'products_for_sale');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'your_notifications_because_you_were_banned');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'your_messages_because_you_were_banned');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'your_requests_because_you_were_banned');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'withdrawal');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'successfully_received_from');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'terms_of_use_page');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'privacy_policy_page');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'about_page');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'refund_terms_page');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'added_review_to_your_product');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'coinbase');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'product_purchase');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'sold_a_product');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'describe_your_review');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'related_prods');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'are_you_delete_open_work');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'are_you_delete_services');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'search_find_job_at');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'connect_with_friends');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'login_connect_friends');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'remember_device');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'register_create_account');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'please_upgrade_to_upload');",
    "INSERT INTO `Wo_Langs` (`id`, `lang_key`) VALUES (NULL, 'type_something_to_post');",


];

$('#input_code').bind("paste keyup input propertychange", function(e) {
    if (isPurchaseCode($(this).val())) {
        $('#button-update').removeAttr('disabled');
    } else {
        $('#button-update').attr('disabled', 'true');
    }
});

function isPurchaseCode(str) {
    var patt = new RegExp("(.*)-(.*)-(.*)-(.*)-(.*)");
    var res = patt.test(str);
    if (res) {
        return true;
    }
    return false;
}

$(document).on('click', '#button-update', function(event) {
    if ($('body').attr('data-update') == 'true') {
        window.location.href = '<?php echo $wo['config']['site_url']?>';
        return false;
    }
    $(this).attr('disabled', true);
    var PurchaseCode = $('#input_code').val();
    $.post('?check', {code: PurchaseCode}, function(data, textStatus, xhr) {
        if (data.status == 200) {
            $('.wo_update_changelog').html('');
            $('.wo_update_changelog').css({
                background: '#1e2321',
                color: '#fff'
            });
            $('.setting-well h4').text('Updating..');
            $(this).attr('disabled', true);
            RunQuery();
        } else {
            $(this).removeAttr('disabled');
            alert(data.error);
        }
    });
});

var queriesLength = queries.length;
var query = queries[0];
var count = 0;
function b64EncodeUnicode(str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}
function RunQuery() {
    var query = queries[count];
    $.post('?update', {
        query: b64EncodeUnicode(query)
    }, function(data, textStatus, xhr) {
        if (data.status == 200) {
            $('.wo_update_changelog').append('<li><span class="added">SUCCESS</span> ~$ mysql > ' + query + '</li>');
        } else {
            $('.wo_update_changelog').append('<li><span class="changed">FAILED</span> ~$ mysql > ' + query + '</li>');
        }
        count = count + 1;
        if (queriesLength > count) {
            setTimeout(function() {
                RunQuery();
            }, 1500);
        } else {
            $('.wo_update_changelog').append('<li><span class="added">Updating Langauges</span> ~$ languages.sh, Please wait, this might take some time..</li>');
            $.post('?run_lang', {
                update_langs: 'true'
            }, function(data, textStatus, xhr) {
              $('.wo_update_changelog').append('<li><span class="fixed">Finished!</span> ~$ Congratulations! you have successfully updated your site. Thanks for choosing WoWonder.</li>');
              $('.setting-well h4').text('Update Log');
              $('#button-update').html('Home <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"> <path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path> </svg>');
              $('#button-update').attr('disabled', false);
              $(".wo_update_changelog").scrollTop($(".wo_update_changelog")[0].scrollHeight);
              $('body').attr('data-update', 'true');
            });
        }
        $(".wo_update_changelog").scrollTop($(".wo_update_changelog")[0].scrollHeight);
    });
}
</script>
