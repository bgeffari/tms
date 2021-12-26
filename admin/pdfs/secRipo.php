<?php include ('../../config/config.php'); ?>

<?php

     
      $start = $_GET['start'];
      $end = $_GET['end'];
              



    require_once __DIR__ . '/vendor/autoload.php';

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    class CustomLanguageToFontImplementation extends \Mpdf\Language\LanguageToFont
    {

        public function getLanguageOptions($llcc, $adobeCJK)
        {
            if ($llcc === 'th') {
                return [false, 'frutiger']; // for thai language, font is not core suitable and the font is Frutiger
            }

            return parent::getLanguageOptions($llcc, $adobeCJK);
        }

    }

    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/fonts',
        ]),
        'fontdata' => $fontData + [
            'frutiger' => [
                'R' => 'Tajawal-Regular.ttf',
                'I' => 'Tajawal-Regular.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ]
        ],
        'default_font' => 'frutiger',
        'languageToFont' => new CustomLanguageToFontImplementation(),
        'margin_right' => 0,'margin_left' => 0,'margin_top' => 0,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0,
    ]);
    // remove hrs from header and footer
    $mpdf->defaultheaderline = 0;
    $mpdf->defaultfooterline = 0;

    $mpdf->SetHeader('
    
    ');

    $style='<style>
    
    table{
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
        .center{
        margin:auto;
    }
    table{
        width:80%;
        margin:auto;
    }
    </style>';

    $mpdf->WriteHTML($style);

    $html = '<body dir="rtl"><br><br><br><br><br>';
            $s_rows_query = mysqli_query($con, "SELECT * FROM section ORDER BY id DESC");
            while ($s_rows = mysqli_fetch_array($s_rows_query)) {

            $id = $s_rows['id'];
            $sec_name = $s_rows['name'];
          
          
if ($start == date("Y-m-d") && $end == date("Y-m-d")) {
$sr = 'تقرير عام';
}else{
$sr = $start.'  -  '.$end;
}
             
    $html .= '
     <br>
     <div class="center">


         <table class="table table-condensed text-center">
    
    <thead>
      <tr>
        <th colspan="6">'.$sr.'</th>

      </tr>
    </thead>
     <thead>
      <tr>
        <th colspan="6">'.$sec_name.'</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td >عدد المهام الكلي</td>
        <td >المهام المنجزة / %</td>
        <td >جاري العمل / %</td>
        <td >لم يكتمل / %</td>
        <td >مرفوضة / %</td>
        <td >النسبة الكليه</td>

      </tr>';

if ($start == date("Y-m-d") && $start == date("Y-m-d")) {
$o_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' ");
        $f_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND status_id = '2' ");
        $n_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND status_id = '4' ");
        $i_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND status_id = '1' ");
        $m_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND status_id = '3' ");

            $fnish = mysqli_num_rows($f_rows_query);
            while ($s_row = mysqli_fetch_array($f_rows_query)) {
                $sum_f += $s_row['rate']; 
            }
            $not = mysqli_num_rows($n_rows_query);
            while ($s_row = mysqli_fetch_array($n_rows_query)) {
                $sum_n += $s_row['rate']; 
            }
            $load = mysqli_num_rows($i_rows_query);
            while ($s_row = mysqli_fetch_array($i_rows_query)) {
                $sum_l += $s_row['rate']; 
            }
            $dis = mysqli_num_rows($m_rows_query);
            while ($s_row = mysqli_fetch_array($m_rows_query)) {
                $sum_d += $s_row['rate']; 
            }
                
            $test = mysqli_num_rows($o_rows_query);
            while ($s_row = mysqli_fetch_array($o_rows_query)) {
                $sum_o += $s_row['rate']; 
            }
            if ($sum_d != 0 ) {
            $sum_d = $sum_d/$dis;
            }else{
            $sum_d = 0;
            }
             if ($sum_l != 0 ) {
            $sum_l = $sum_l/$load;
            }else{
            $sum_l = 0;
            }
            if ($sum_n != 0 ) {
            $sum_n = $sum_n/$not;
            }else{
            $sum_n = 0;
            }
            if ($sum_f != 0 ) {
             $sum_f = $sum_f/$fnish;
            }else{
                $sum_f = 0;
            }
            if ($sum_f != 0 ) {
            $sum_o = $sum_o/$test;
            }else{
            $sum_o = 0;
            }
}else{
    $o_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND (date_added BETWEEN '$start' AND '$end' )");
        $f_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND status_id = '2' AND (date_added BETWEEN '$start' AND '$end' )");
        $n_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND status_id = '4' AND (date_added BETWEEN '$start' AND '$end' )");
        $i_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND status_id = '1' AND (date_added BETWEEN '$start' AND '$end' )");
        $m_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE type_id = '$id' AND status_id = '3' AND (date_added BETWEEN '$start' AND '$end' )");

            $fnish = mysqli_num_rows($f_rows_query);
            $not = mysqli_num_rows($n_rows_query);
            $load = mysqli_num_rows($i_rows_query);
            $dis = mysqli_num_rows($m_rows_query);
                
            $test = mysqli_num_rows($o_rows_query);
}
        
            if ($test == 0) {
                $html .='
                  <tr>
                    <td >لا توجد مهام</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                   
                  </tr>';
            }else{
              

                $html .='
                  <tr>
                    <td >'.$test.'</td>
                    <td >'.$fnish.'  /  '.$sum_f.'</td>
                    <td >'.$not.'  /   '.$sum_n.'</td>
                    <td >'.$load.'  /   '.$sum_l.'</td>
                    <td >'.$dis.'  /   '.$sum_d.'</td>
                    <td >'.$sum_o.'%</td>
                    
                  </tr>';
              }
      $html .='
    </tbody>
  </table>
  </div><br>
  
    ';

}   


    $mpdf->WriteHTML($html);

      
    $html .= '</body>';

    // $mpdf->AddPage();



    $rand = rand ( 10000 , 99999 );
    // getting the pdf
    $mpdf->Output('employeerate'.$rand.'.pdf', 'D');

?>