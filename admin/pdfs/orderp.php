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
     $em_rows_query = mysqli_query($con, "SELECT * FROM employees ORDER BY id DESC ");
            while($em_row = mysqli_fetch_array($em_rows_query)){
                $id = $em_row['id'];
                $name = $em_row['name'];

          

           

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
        $e_rows_query = mysqli_query($con, "SELECT * FROM missions  ORDER BY id DESC ");
            while($e_row = mysqli_fetch_array($e_rows_query)){
            $m_name = $e_row['name'];
            $date = $e_row['end_date'];
            $emp = $e_row['employees'];
            $emps = explode(",", $emp);
            if (in_array($id, $emps)) {
                 $html .='<tr>
        <td >'.$e_row['name'].' </td>
        <td >'.$e_row['end_date'].'</td>
      </tr>';
            }else{
                 $html .='<tr>
        
      </tr>';
            }
           
               }
            
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