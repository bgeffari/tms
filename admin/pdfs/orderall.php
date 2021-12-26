<?php include ('../../config/config.php'); ?>

<?php

     
            
              




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
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees  ORDER BY id DESC ");
            while($e_row = mysqli_fetch_array($e_rows_query)){
            $id = $e_row['id'];
            $name = $e_row['name'];
             
    $html .= '
     <br>
     <div class="center">


         <table class="table table-condensed text-center">
    <thead>
      <tr>
        <th colspan="5">'.$name.'</th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td >المهمة </td>
        <td >عدد الايام</td>
        <td >الحالة</td>
        <td >ملاحظة طالب الخدمة</td>
        <td >ملاحظة مقدم الخدمة</td>
        <td >الإدارة طالبة الخدمة</td>
        <td >ايام الأنجاز</td>
        <td >نسبة الأنجاز</td>
      </tr>';
        $o_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' ");
                
                
            $test = mysqli_num_rows($o_rows_query);
            if ($test == 0) {
                $html .='
                  <tr>
                    <td >لا توجد مهام يعمل عليها</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                    <td >--</td>
                  </tr>';
            }else{
            while($o_row = mysqli_fetch_array($o_rows_query)){
                $date_add = $o_row['date_added'];
                $date_end = $o_row['date_end'];
                $date_added = date_create($date_add);
        $date_dnish = date_create($date_end);
        $date_diff = date_diff($date_dnish , $date_added);
        $num_day = $date_diff->format("%a");
                $miss = $o_row['mission_id'];
                $status = $o_row['status_id'];
                $mange_cerv = $o_row['mange_cerv'];
                $status_query = mysqli_query($con, "SELECT * FROM status WHERE id = '$status' ");
                $st_row = mysqli_fetch_array($status_query);
                $status_name = $st_row['name_only'];
                $req_detail = $o_row['req_details'];
                $emp_detail = $o_row['employ_details'];
                $or_rate = $o_row['rate'];
                $m_query = mysqli_query($con, "SELECT * FROM missions WHERE id = '$miss' ");
                $m_row = mysqli_fetch_array($m_query);
                $name = $m_row['name'];
                $date = $m_row['end_date'];

                $html .='
                  <tr>
                    <td >'.$name.'</td>
                    <td >'.$date.'</td>
                    <td >'.$status_name.'</td>
                    <td >'.$req_detail.'</td>
                    <td >'.$emp_detail.'</td>
                    <td >'.$mange_cerv.'</td>
                    <td >'.$num_day.'</td>
                    <td >'.$or_rate.' %</td>
                  </tr>';
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