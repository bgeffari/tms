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
    <tbody>
      <tr>
        <td >عدد المهام الكلي</td>
        <td >المهام المنجزة </td>
        <td >لم يكتمل</td>
        <td >جاري العمل  </td>
        <td >مرفوضة </td>
        <td >معلقة </td>
        <td >نسبة الإنجاز </td>

      </tr>';

if ($start == date("Y-m-d") && $start == date("Y-m-d")) {
$o_rows_query = mysqli_query($con, "SELECT * FROM orders ORDER BY id DESC");
        $f_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '2' ");
        $n_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '4' ");
        $i_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '1' ");
        $m_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '3' ");
        $ma_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '5' ");

        $fnish = mysqli_num_rows($f_rows_query);
            $not = mysqli_num_rows($n_rows_query);
            $load = mysqli_num_rows($i_rows_query);
            $dis = mysqli_num_rows($m_rows_query);
            $test = mysqli_num_rows($o_rows_query);
            $ma = mysqli_num_rows($ma_rows_query);

}else{
    $o_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE (date_added BETWEEN '$start' AND '$end' )");
        $f_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '2' AND (date_added BETWEEN '$start' AND '$end' )");//تم الانجاز
        $n_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '4' AND (date_added BETWEEN '$start' AND '$end' )");//لم يكتمل
        $i_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '1' AND (date_added BETWEEN '$start' AND '$end' )");//جاري العمل
        $m_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '3' AND (date_added BETWEEN '$start' AND '$end' )");//مرفوضة
        $ma_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE status_id = '3' AND (date_added BETWEEN '$start' AND '$end' )");//معلقة

            $fnish = mysqli_num_rows($f_rows_query);
            $not = mysqli_num_rows($n_rows_query);
            $load = mysqli_num_rows($i_rows_query);
            $dis = mysqli_num_rows($m_rows_query);
            $test = mysqli_num_rows($o_rows_query);
            $ma = mysqli_num_rows($ma_rows_query);
}
$rate =($fnish/$test)*100;
        
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
                    <td >'.$fnish.'</td>
                    <td >'.$not.'</td>
                    <td >'.$load.'</td>
                    <td >'.$dis.'</td>
                    <td >'.$ma.'</td>
                    <td >'.round($rate) .'%</td>
                  </tr>';
              }
      $html .='
    </tbody>
  </table>
  </div><br>
  
    ';  


    $mpdf->WriteHTML($html);

      
    $html .= '</body>';

    // $mpdf->AddPage();



    $rand = rand ( 10000 , 99999 );
    // getting the pdf
    $mpdf->Output('sys'.$rand.'.pdf', 'D');

?>