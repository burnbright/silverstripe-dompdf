# PDF Generation via DOMPDF Library

Maintainer: Jeremy Shipman (jeremy@burnbright.net)

http://code.google.com/p/dompdf/

Input:

 * HTML string (which could be rendered template)
 * HTML File
 
Output

 * PDF File location
 * SS File
 * PDF binary stream to browser

## Example usage

	$pdf = new SS_DOMPDF();
	$pdf->setHTML($mydataobject->renderWith('MyTemplate'));
	$pdf->render();
	$pdf->toFile('mypdf.pdf');
	
## Debugging

The $pdf->streamdebug(); function is useful for quickly viewing pdfs, particularly
if your browser supports displaying pdfs, rather than downloading.

You can check your html before it is converted like this:

	echo $mydataobject->renderWith('MyTemplate');die();