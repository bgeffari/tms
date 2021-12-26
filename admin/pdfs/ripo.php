<?php include ('../../config/config.php'); ?>

<?php

     
      $id = $_GET['id'];
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
        if (isset($id)) {
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees  WHERE id = '$id' ");
        }else{
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees  ORDER BY id DESC");
        }
            while($e_row = mysqli_fetch_array($e_rows_query)){
            $id = $e_row['id'];
            $name = $e_row['name'];

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
        <th colspan="6">'.$name.'</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td >عدد المهام </td>
        <td >المهام المنجزة</td>
        <td >جاري العمل</td>
        <td >لم يكتمل</td>
        <td >مرفوضة</td>
        <td >تقييم الموظف</td>

      </tr>';

if ($start == date("Y-m-d") && $start == date("Y-m-d")) {
        $o_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' ");
        $f_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND status_id = '2' ");
        $n_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND status_id = '4' ");
        $i_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND status_id = '1' ");
        $m_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND status_id = '3' ");
        $c_rows_query = mysqli_query($con, "SELECT * FROM req_cours WHERE status = '2' AND user_id = '$id' AND user_roll = 'mar' ");

            $fnish = mysqli_num_rows($f_rows_query);
            $not = mysqli_num_rows($n_rows_query);
            $load = mysqli_num_rows($i_rows_query);
            $dis = mysqli_num_rows($m_rows_query);
            $test = mysqli_num_rows($o_rows_query);
            $cours = mysqli_num_rows($c_rows_query);
            
}else{
    $o_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND (date_added BETWEEN '$start' AND '$end' )");
        $f_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND status_id = '2' AND (date_added BETWEEN '$start' AND '$end' )");
        $n_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND status_id = '4' AND (date_added BETWEEN '$start' AND '$end' )");
        $i_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND status_id = '1' AND (date_added BETWEEN '$start' AND '$end' )");
        $m_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' AND status_id = '3' AND (date_added BETWEEN '$start' AND '$end' )");
        $c_rows_query = mysqli_query($con, "SELECT * FROM req_cours WHERE user_id = '$id' AND user_roll = N'mar' AND status = '2' AND (date_added BETWEEN '$start' AND '$end' ) ");
            $fnish = mysqli_num_rows($f_rows_query);
            $not = mysqli_num_rows($n_rows_query);
            $load = mysqli_num_rows($i_rows_query);
            $dis = mysqli_num_rows($m_rows_query);
            $test = mysqli_num_rows($o_rows_query);
            $cours = mysqli_num_rows($c_rows_query);
           
}
        
            if ($test == 0) {
                $html .='
                  <tr>
                    <td >لا توجد مهام يعمل عليها</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td> 
                  </tr>
                  ';
            }else{
            while($o_row = mysqli_fetch_array($o_rows_query)){
              $sum = 0;
              while($c_row = mysqli_fetch_array($c_rows_query)){
                $cours_id = $c_row['cours_id'];
                $cours_query = mysqli_query($con, "SELECT * FROM cours WHERE id = '$cours_id'");
                $cours_row = mysqli_fetch_array($cours_query);
                $sum += $cours_row['score'];
              }
                $html .='
                  <tr>
                    <td >'.$test.'</td>
                    <td >'.$fnish.'</td>
                    <td >'.$not.'</td>
                    <td >'.$load.'</td>
                    <td >'.$dis.'</td>
                    <td >'.$e_row['rate'].'</td>
                  </tr>
                  <tr>
                  <td >الكورسات</td>
                  <td colspan="3">اكمل عدد '.$cours.' كورسات</td>
                  <td colspan="3">جمع عدد '.$sum.' نقاط </td>
                </tr>
                  ';
              }}
      $html .='
    </tbody>
  </table>
  </div>
  
    ';
}    

    $mpdf->WriteHTML($html);
      
    $html .= '</body>';

    // $mpdf->AddPage();



    $rand = rand ( 10000 , 99999 );
    // getting the pdf
    $mpdf->Output('employeerate'.$rand.'.pdf', 'D');

?>