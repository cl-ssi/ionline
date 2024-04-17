<?php

namespace App\Services;

use App\Models\User;

class ImageService
{
    /**
     * How to use the ImageService service:
     *
     * return app(ImageService::class)->createVisator(auth()->user());
     * return app(ImageService::class)->createDocumentNumber("2342-Xdf4", "13.089");
     * return app(ImageService::class)->createSignature(auth()->user());
     * 
     * para verla en el navegador :
     **/
     // $image = base64_decode(app(ImageService::class)->createDocumentNumber("2342-Xdf4", "13.089"));
     // return response($image)->header('Content-Type', 'image/png');

    /**
     * @var string
     */
    public $fontLight;

    /**
     * @var string
     */
    public $fontConsolas;

    /**
     * @var string
     */
    public $fontConsolasBold;

    /**
     * @var string
     */
    public $fontBold;

    /**
     * @var string
     */
    public $fontRegular;

    /**
     * Initialize the service
     */
    public function __construct()
    {
        $this->fontLight = public_path('fonts/verdana-italic.ttf');
        $this->fontBold = public_path('fonts/verdana-bold-2.ttf');
        $this->fontRegular = public_path('fonts/Verdana.ttf');
        $this->fontConsolas = public_path('fonts/consolas.ttf');
        $this->fontConsolasBold = public_path('fonts/consolas-bold.ttf');
    }

    /**
     * Create the image of Visator
     *
     * @param  \App\Models\User $user
     * @return string
     */
    public function createVisator(User $user)
    {
        /**
         * Define the parameters
         */
        $widthImage = 300;
        $heightImage = 100;
        $xPading = 30;
        $yPading = 90;

        /**
         * Create an image of the GDImage instance
         */
        $imagen = @imagecreate($widthImage, $heightImage) or die("Cannot Initialize new GD image stream");

        /**
         * Assign color to an image
         */
        $white = imagecolorallocate($imagen, 255, 255, 255);

        /**
         * Revisar
         */
        imagefilledrectangle($imagen, 1, 1, 20, 20, $white);
        $textColor = imagecolorallocate($imagen, 0, 0, 0);

        /**
         * Add the initials of the visitor's name
         */
        imagettftext($imagen, 80, 0, $xPading, $yPading, $textColor, $this->fontLight, $user->initials);

        /**
         * Generate the image in base 64
         */
        ob_start();

        imagepng($imagen);

        $imageBase64 = base64_encode(ob_get_clean());

        imagedestroy($imagen);

        return $imageBase64;
    }

    /**
     * Create the image with the document number
     *
     * @param  string $validationCode
     * @param  string $documentNumber
     * @param  string $verificationLink TODO: usar app_url
     * @return string
     */
    public function createDocumentNumber($validationCode, $documentNumber, $verificationLink = "https://i.saludtarapaca.gob.cl/validador")
    {
        /**
         * Define the parameters
         */
        $widthNumber = 100;

        $widthImage = 1100;
        $heightImage = 280;
        $fontSize = 25;
        $xPading = 15;
        $yPading = 33;

        /**
         * Create an image of the GDImage instance
         */
        $imagen = @imagecreate($widthImage, $heightImage) or die("Cannot Initialize new GD image stream");

        /**
         * Assign the color to the image
         */
        $white = imagecolorallocate($imagen, 255, 255, 255);

        /**
         * Create the rectangle
         */
        imagefilledrectangle($imagen, 1, 1, $widthImage - 2, $heightImage - 2, $white);
        $textColor = imagecolorallocate($imagen, 0, 0, 0);

        /**
         * Add text to image
         */
        $text = "Firmado electrónicamente de acuerdo a la ley Nº 19.799";
        imagettftext($imagen, $fontSize + 3, 0, $xPading * 1, $yPading, $textColor, $this->fontLight, $text);

        /**
         * Add verification link to image
         */
        imagettftext($imagen, $fontSize, 0, $xPading * 1, round($yPading * 2.3), $textColor, $this->fontConsolas, "$verificationLink id:$validationCode");

        /**
         * Add the document number to image
         */
        imagettftext($imagen, $fontSize + 35, 0, $xPading + $widthImage - $widthNumber - 600, $yPading * 8, $textColor, $this->fontConsolasBold, $documentNumber);

        /**
         *  Generate the image in base 64
         */
        ob_start();

        imagepng($imagen);

        $imageBase64 = base64_encode(ob_get_clean());

        imagedestroy($imagen);

        return $imageBase64;
    }

    /**
     * Create the digital signature image
     *
     * @param  \App\Models\User $user
     * @return string
     */
    public function createSignature(User $user)
    {
        /**
         * Define the parameters
         */
        $width = 930;
        $height = 206;
        $fontSize = 20;
        $marginTop = 1;
        $xAxis = 12;
        $yPading = 37;

        /**
         * Create an image
         */
        $imagen = @imagecreate($width, $height) or die("Cannot Initialize new GD image stream");

        /**
         * Add the gray border
         */
        imagecolorallocate($imagen, 204, 204, 204);
        $white = imagecolorallocate($imagen, 255, 255, 255);

        /**
         * Create the rectangle
         */
        imagefilledrectangle($imagen, 3, 3, $width - 4, $height - 4, $white);
        $textColor = imagecolorallocate($imagen, 0, 0, 0);
        $textColorAzul = imagecolorallocate($imagen, 0, 0, 144);

        /**
         * Obtain the Digital Signature Logo
         */
        $digitalSignatureLogo = imagecreatefrompng(public_path('images/firma_gobierno170x177.png'));

        /**
         * Get image width
         */
        $firmaDigitalWidth = imagesx($digitalSignatureLogo);

        /**
         * Merge the logo with the image
         */
        imagecopymerge($imagen, $digitalSignatureLogo, $width - $firmaDigitalWidth - 6, 12, 0, 0, imagesx($digitalSignatureLogo) - 5, imagesy($digitalSignatureLogo) - 5, 100);


        /**
         * Add date and time of signing
         */
        imagettftext($imagen, $fontSize - 1, 0, $xAxis, $yPading * 1.0 + $marginTop, $textColorAzul, $this->fontRegular, 'FIRMADO el ' . now()->format('Y-m-d \a \l\a\s H:i'));

        /**
         * Add the signer's name to the image
         */
        imagettftext($imagen, $fontSize + 15, 0, $xAxis - 2, round($yPading * 2.6 + $marginTop + 0.3), $textColorAzul, $this->fontBold, $user->shortName);

        /**
         * Add the organizational unit to the image
         */
        imagettftext($imagen, $fontSize + 1, 0, $xAxis, $yPading * 3.8 + $marginTop + 0.4, $textColor, $this->fontRegular, $user->organizationalUnit->name);

        /**
         * Add the name of the app on the image
         */
        imagettftext($imagen, $fontSize + 1, 0, $xAxis, round($yPading * 5.0 + $marginTop + 0.5), $textColor, $this->fontRegular, env('APP_SS'));

        /**
         *  Generate the image in base 64
         */
        ob_start();

        imagepng($imagen);

        $imageBase64 = base64_encode(ob_get_clean());

        imagedestroy($imagen);

        return $imageBase64;
    }
}
