<?php

namespace App\Tests\Form\Type;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\Form\Test\TypeTestCase;

class ClientTypeTest extends TypeTestCase
{
    // public function testSubmitValidData()
    // {
    //     $formData = [
    //         'name' => 'Nombre test',
    //         'surname' => 'Apellidos test',
    //         'birthdate' => new \DateTime(),
    //         'nie' => '98765432e',
    //         'address' => 'address test',
    //         'postalcode' => 12345,
    //         'town' => 'town test',
    //         'city' => 'city test',
    //         'province' => 'province test',
    //         'country' => 'country test',
    //     ];

    //     $model = new Client();
    //     // $formData will retrieve data from the form submission; pass it as the second argument
    //     // $formData recuperará datos del envío del formulario; pasarlo como segundo argumento
    //     $form = $this->factory->create(ClientType::class, $model);

    //     $expected = new Client();
    //     // ...populate $object properties with the data stored in $formData
    //     // ...propiedades de $object con los datos almacenados en $formData

    //     // submit the data to the form directly
    //     // enviar los datos al formulario directamente
    //     $form->submit($formData);

    //     // This check ensures there are no transformation failures
    //     // Esta verificación garantiza que no haya fallos de transformación
    //     $this->assertTrue($form->isSynchronized());

    //     dump($expected);dump($model);die;

    //     // check that $formData was modified as expected when the form was submitted
    //     // comprobar que $formData se modificó como se esperaba cuando se envió el formulario
    //     $this->assertEquals($expected, $model);
    // }

    // public function testCustomFormView()
    // {
    //     $formData = new Client();
    
    //     $formData->setName('Nombre test');
    //     $formData->setSurname('Apellidos test');
    //     $formData->setBirthdate(new \DateTime());
    //     $formData->setNie('12345655s');
    //     $formData->setAddress('Address test');
    //     $formData->setPostalcode(12345);
    //     $formData->setTown('Población test');
    //     $formData->setCity('Ciudad test');
    //     $formData->setProvince('Provincia test');
    //     $formData->setTown('País test');
    //     // ... prepare the data as you need

    //     // The initial data may be used to compute custom view variables
    //     $view = $this->factory->create(ClientType::class, $formData)
    //         ->createView();

    //     $this->assertArrayHasKey('custom_var', $view->vars);
    //     $this->assertSame('expected value', $view->vars['custom_var']);
    // }
}