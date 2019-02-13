<?php
require('rotation.php');
class PDF extends PDF_Rotate
{
function Header()
{

	#$this->AddFont('kozminproregular','','kozminproregular.php');
    //Put the watermark
    /*
    $this->SetFont('Arial','B',50);
    $this->SetTextColor(255,192,203);
    $this->RotatedText(35,190,'W a t e r m a r k   d e m o',45);
    */
}

function RotatedText($x, $y, $txt, $angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

}
?>