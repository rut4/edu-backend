<?php
/**
 * Created by PhpStorm.
 * User: Eduard
 * Date: 23.12.13
 * Time: 20:09
 */

namespace App\Model\Quote;


class ConverterFactory
{
    public function getConverters()
    {
        return [
            new DataConverter,
            new AddressConverter,
            new ItemsConverter
        ];
    }
}
