<?php
include_once 'db_con.php';

$id = $_GET['b_id'] ?? null;

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="G1 Fashion">
    <title>GST Bill Print</title>
    <link rel="stylesheet" href="assets/css/invoice_style.css">
    <link rel="shortcut icon" href="assets/img/favicons.ico">
</head>
<body>
    <div class="tm_invoice_wrap">
        <div class="tm_invoice tm_style1 tm_type1" id="tm_download_section">
            <?php if ($id) {
                $query = "SELECT * FROM `bill` WHERE b_id='$id'";
                $query_run = mysqli_query($conn, $query);

                if ($query_run && mysqli_num_rows($query_run) > 0) {
                    $row1 = mysqli_fetch_array($query_run);
                    $date = $row1['b_date'];
                    $dateObject = new DateTime($date);
                    $dynamicDate = $dateObject->format('d-m-Y');

                    // Fetch owner details
                    $owner_id = $row1['owner_id'] ?? 1;
                    $owner_query = mysqli_query($conn, "SELECT * FROM users WHERE owner_id='$owner_id'");
                    $owner = mysqli_fetch_assoc($owner_query);
            ?>
            <div class="tm_invoice_in">
                <div class="tm_invoice_head tm_top_head tm_mb10 tm_align_center">
                    <div class="tm_invoice_left">
                        <div class="tm_logo" style="display: flex; align-items: center; gap: 10px;">
                            <?php if (!empty($owner['img'])) { ?>
                                <img src="assets/img/<?php echo htmlspecialchars($owner['img']); ?>" alt="Logo" style="max-height: 50px;">
                            <?php } ?>
                            <h2 class="tm_white_color" style="margin: 0; font-size: 24px; font-weight: bold;"><?php echo htmlspecialchars($owner['name'] ?? 'G1 Fashion'); ?></h2>
                        </div>
                    </div>
                    <div class="tm_invoice_right tm_text_right tm_mobile_hide">
                        <div class="tm_f50 tm_text_uppercase tm_white_color">GST Bill</div>
                    </div>
                    <div class="tm_shape_bg tm_accent_bg tm_mobile_hide"></div>
                </div>
                <div class="tm_invoice_info tm_mb25">
                    <div class="tm_card_note tm_mobile_hide" style="color: #111 !important;">
                        Mobile: <b class="tm_primary_color" style="color: #111 !important;"><?php echo htmlspecialchars($owner['mobile_1'] ?? ''); ?></b>
                        <?php if (!empty($owner['email'])) { ?>
                            | Email: <b class="tm_primary_color" style="color: #111 !important;"><?php echo htmlspecialchars($owner['email']); ?></b>
                        <?php } ?>
                    </div>
                    <div class="tm_invoice_info_list tm_white_color">
                        <p class="tm_invoice_number tm_m0">Bill No: <b><?php echo htmlspecialchars($row1['bill_no']); ?></b></p>
                        <p class="tm_invoice_date tm_m0">Date: <b><?php echo $dynamicDate; ?></b></p>
                    </div>
                    <div class="tm_invoice_seperator tm_accent_bg"></div>
                </div>

                <div class="tm_invoice_left tm_mb20" style="color: #111 !important;">
                    <p class="tm_mb2" style="color: #111 !important;"><b class="tm_primary_color" style="color: #111 !important;">From:</b> <?php echo htmlspecialchars($owner['name']); ?></p>
                    <p class="tm_mb2" style="color: #111 !important;"><b class="tm_primary_color" style="color: #111 !important;">Address:</b> <?php echo htmlspecialchars($owner['address'] ?? ''); ?></p>
                    <p class="tm_mb2" style="margin-top: 10px; color: #111 !important;"><b class="tm_primary_color" style="color: #111 !important;">To (Party Name):</b> <?php echo htmlspecialchars($row1['p_name']); ?></p>
                    <p class="tm_mb2" style="color: #111 !important;"><b class="tm_primary_color" style="color: #111 !important;">GSTIN:</b> <?php echo htmlspecialchars($row1['gst'] ?? ''); ?></p>
                </div>

                <div class="tm_table tm_style1" style="color: #111 !important;">
                    <div class="tm_table_responsive">
                        <table>
                            <thead>
                                <tr class="tm_accent_bg">
                                    <th class="tm_width_1 tm_semi_bold tm_white_color tm_text_center">No</th>
                                    <th class="tm_width_2 tm_semi_bold tm_white_color">Chalan No</th>
                                    <th class="tm_width_3 tm_semi_bold tm_white_color">Design No</th>
                                    <th class="tm_width_2 tm_semi_bold tm_white_color tm_text_center">Total Metre</th>
                                    <th class="tm_width_2 tm_semi_bold tm_white_color tm_text_center">Rate</th>
                                    <th class="tm_width_2 tm_semi_bold tm_white_color tm_text_center">Chalan Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $chalan_no_arr = explode(', ', $row1['chalan_no']);
                                $c_amount_arr = explode(', ', $row1['c_amount']);
                                $design_no_arr = isset($row1['design_no']) ? explode(', ', $row1['design_no']) : [];

                                for ($i = 0; $i < count($chalan_no_arr); $i++) {
                                    $c_no = $chalan_no_arr[$i] ?? '';
                                    $c_amt = $c_amount_arr[$i] ?? '';
                                    $c_detail_query = mysqli_query($conn, "SELECT design_no, total_metre, rate FROM chalan WHERE chalan_no = '" . mysqli_real_escape_string($conn, $c_no) . "' AND owner_id = $owner_id LIMIT 1");
                                    $c_detail = mysqli_fetch_assoc($c_detail_query);
                                    
                                    $ch_designs = array_map('trim', explode('/', $c_detail['design_no'] ?? ''));
                                    $ch_metres = array_map('trim', explode('/', $c_detail['total_metre'] ?? ''));
                                    $ch_rates = array_map('trim', explode('/', $c_detail['rate'] ?? ''));
                                    
                                    $saved_design = $design_no_arr[$i] ?? ($ch_designs[0] ?? '');
                                    $selected_index = array_search($saved_design, $ch_designs);
                                    if ($selected_index === false) {
                                        $selected_index = 0;
                                    }
                                    
                                    $c_design = $ch_designs[$selected_index] ?? '';
                                    $c_metre = $ch_metres[$selected_index] ?? '';
                                    $c_rate = $ch_rates[$selected_index] ?? '';
                                ?>
                                <tr>
                                    <td class="tm_text_center"><?php echo $i + 1; ?></td>
                                    <td class="tm_primary_color"><b><?php echo htmlspecialchars($c_no); ?></b></td>
                                    <td class="tm_primary_color"><?php echo htmlspecialchars($c_design); ?></td>
                                    <td class="tm_text_center tm_primary_color"><?php echo htmlspecialchars($c_metre); ?></td>
                                    <td class="tm_text_center tm_primary_color">₹ <?php echo htmlspecialchars($c_rate); ?></td>
                                    <td class="tm_text_center tm_primary_color">₹ <?php echo htmlspecialchars($c_amount_arr[$i] ?? '0.00'); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tm_invoice_footer tm_border_top tm_mb15 tm_m0_md" style="margin-top: 20px; color: #111 !important;">
                    <div class="tm_left_footer">
                        <p class="tm_mb2" style="color: #111 !important;"><b class="tm_primary_color" style="color: #111 !important;">Terms & Conditions:</b></p>
                        <p class="tm_m0"><b>30 - 45 Days Payment Due*</b></p>
                    </div>
                    <div class="tm_right_footer">
                        <table class="tm_mb15">
                            <tbody>
                                <tr>
                                    <td class="tm_width_3 tm_primary_color" style="color: #111 !important;">Sub Total:</td>
                                    <td class="tm_width_3 tm_primary_color tm_text_right" style="color: #111 !important;">₹ <?php echo htmlspecialchars($row1['c_total_amount']); ?></td>
                                </tr>
                                <tr>
                                    <td class="tm_width_3 tm_primary_color" style="color: #111 !important;">Discount (<?php echo htmlspecialchars($row1['d_rate']); ?>%):</td>
                                    <td class="tm_width_3 tm_primary_color tm_text_right" style="color: #111 !important;">- ₹ <?php echo htmlspecialchars($row1['d_amount']); ?></td>
                                </tr>
                                 <?php
                                 $cgst_rate_val = isset($row1['cgst_rate']) ? (float)$row1['cgst_rate'] : 2.5;
                                 $sgst_rate_val = isset($row1['sgst_rate']) ? (float)$row1['sgst_rate'] : 2.5;
                                 $total_gst_rate_val = $cgst_rate_val + $sgst_rate_val;
                                 ?>
                                 <tr>
                                     <td class="tm_width_3 tm_primary_color" style="color: #111 !important;">CGST (<?php echo htmlspecialchars($cgst_rate_val); ?>%):</td>
                                     <td class="tm_width_3 tm_primary_color tm_text_right" style="color: #111 !important;">₹ <?php echo htmlspecialchars($row1['cgst']); ?></td>
                                 </tr>
                                 <tr>
                                     <td class="tm_width_3 tm_primary_color" style="color: #111 !important;">SGST (<?php echo htmlspecialchars($sgst_rate_val); ?>%):</td>
                                     <td class="tm_width_3 tm_primary_color tm_text_right" style="color: #111 !important;">₹ <?php echo htmlspecialchars($row1['sgst']); ?></td>
                                 </tr>
                                 <tr>
                                     <td class="tm_width_3 tm_primary_color tm_bold" style="color: #111 !important;">Total GST (<?php echo htmlspecialchars($total_gst_rate_val); ?>%):</td>
                                     <td class="tm_width_3 tm_primary_color tm_bold tm_text_right" style="color: #111 !important;">₹ <?php echo htmlspecialchars($row1['total_gst']); ?></td>
                                 </tr>
                                <tr class="tm_accent_bg">
                                    <td class="tm_width_3 tm_bold tm_f16 tm_white_color">Final Amount:</td>
                                    <td class="tm_width_3 tm_bold tm_f16 tm_white_color tm_text_right">₹ <?php echo htmlspecialchars($row1['total_amount']); ?></td>
                                </tr>
                                <tr>
                                    <td class="tm_width_3 tm_primary_color" style="color: #111 !important;">Paid Amount:</td>
                                    <td class="tm_width_3 tm_primary_color tm_text_right" style="color: #111 !important;">₹ <?php echo htmlspecialchars($row1['paid_amount']); ?></td>
                                </tr>
                                <tr class="tm_gray_bg">
                                    <td class="tm_width_3 tm_primary_color tm_bold" style="color: #111 !important;">Balance Due:</td>
                                    <td class="tm_width_3 tm_primary_color tm_bold tm_text_right" style="color: #111 !important;">₹ <?php echo htmlspecialchars($row1['pending_amount']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tm_invoice_footer tm_type1 tm_hide_print" style="margin-top: 30px;">
                    <div class="tm_left_footer"></div>
                    <div class="tm_right_footer">
                        <div class="tm_invoice_btns">
                            <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                                <span class="tm_btn_text">Print</span>
                            </a>
                            <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
                                <span class="tm_btn_text">Download</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jspdf.min.js"></script>
    <script src="assets/js/html2canvas.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>