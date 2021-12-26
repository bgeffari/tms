<?php include ('../../config/config.php'); ?>

<?php

      $id = $_GET['id'];
            $e_rows_query = mysqli_query($con, "SELECT * FROM employees WHERE id = '$id' ");
            $e_row = mysqli_fetch_array($e_rows_query);
            $name = $e_row['name'];
            
              




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
      </tr>';
        $o_rows_query = mysqli_query($con, "SELECT * FROM orders WHERE employee_id = '$id' ");
            $test = mysqli_num_rows($o_rows_query);
            if ($test == 0) {
                $html .='
                  <tr>
                    <td >لا توجد مهام يعمل عليها</td>
                    <td >--</td>
                  </tr>';
            }else{
            while($o_row = mysqli_fetch_array($o_rows_query)){
                $miss = $o_row['mission_id'];
                $m_query = mysqli_query($con, "SELECT * FROM missions WHERE id = '$miss' ");
                $m_row = mysqli_fetch_array($m_query);
                $name = $m_row['name'];
                $date = $m_row['end_date'];

                $html .='
                  <tr>
                    <td >'.$name.'</td>
                    <td >'.$date.'</td>
                  </tr>';
              }}
      $html .='
    </tbody>
  </table>
  </div>
  
    ';

    $mpdf->WriteHTML($html);
      
    $html .= '</body>';

    // $mpdf->AddPage();



    $rand = rand ( 10000 , 99999 );
    // getting the pdf
    $mpdf->Output('employeerate'.$rand.'.pdf', 'D');

?>