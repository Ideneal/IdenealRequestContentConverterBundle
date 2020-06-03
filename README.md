# IdenealRequestContentConverterBundle

[![Packagist](https://img.shields.io/packagist/v/ideneal/request-content-converter-bundle.svg?style=flat-square)](https://packagist.org/packages/ideneal/request-content-converter-bundle)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/Ideneal/IdenealRequestContentConverterBundle/master/LICENSE)
[![Travis branch](https://img.shields.io/travis/Ideneal/IdenealRequestContentConverterBundle/master.svg?style=flat-square)](https://travis-ci.org/Ideneal/IdenealRequestContentConverterBundle)
[![Codacy branch](https://img.shields.io/codacy/fd2aeec49ab54ba4960ad04352ee2ce2/master.svg?style=flat-square)](https://www.codacy.com/app/ideneal-ztl/IdenealRequestContentConverterBundle)

This is a Symfony bundle that extends the features of [SensioFrameworkExtraBundle](https://github.com/sensiolabs/SensioFrameworkExtraBundle).
It provides a way to  deserialize and validate the request content into a specified class or entity.

Installation
------------

Add the bundle to your `composer.json` file:

```bash
composer require ideneal/request-content-converter-bundle
``` 

Usage
-----

### ContentParamConverter

The ContentParamConverter permits you to convert the request content into a specific controller action parameter.

Let's see a simple use case where you want to subscribe a lead.
Create a simple Lead class:

```php
namespace App\Inputs;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class Lead
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @Assert\Email(groups={"strict"})
     * @Groups("registration")
     */
    private $email;

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
```

Inside the controller create a simple action and add the `ContentParamConverter` annotation specifying the request format:

```php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Ideneal\Bundle\RequestContentConverterBundle\Configuration\ContentParamConverter;
use App\Inputs\Lead;

class SubscribeController extends AbstractController
{
    /**
     * @Route("/subscribe", name="subscribe")
     * @ContentParamConverter("lead", methods={"POST"}, format="json")
     */
    public function subscribe(Lead $lead)
    {
        /* Do some operations .... */
         
        dump($lead);
        return new JsonResponse(['message' => 'ok']);
    }
}
```
In this case the annotation ContentParamConverter automatically maps the request content json keys into related Lead properties and validate it.

You could also use as well `Json` and `Xml` without set the format instead of ContentParamConverter.


### EntityContentParamConverter

In order to map the request content to a Doctrine entity you could use EntityContentParamConverter.
You could also use `JsonEntity` and `XmlEntity` where the format has been specified.

Let's see a use case where you have to update a product in db.
So you have an entity _Product_.

```php
namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
```

In order to update a specific Product you could create the following action:

```php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Ideneal\Bundle\RequestContentConverterBundle\Configuration\JsonEntity;
use App\Entity\Product;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/products/{id}", name="update_product", methods={"PUT"})
     * @JsonEntity("product", class="App\Entity\Product")
     */
    public function update(Product $product)
    {
        /* Do some operations... */

        dump($product);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        return new JsonResponse(['message' => 'ok']);
    }
}
```

Within controller action the `$product` has just been updated and validated by the json request.

Annotation Options
------------------

In addiction to `format` parameter you could set other options.

### groups

Sometimes, you want to deserialize different sets of attributes from your selected class.
Groups are a handy way to achieve this need.

The value of the groups key can be a single string, or an array of strings.

### validate

Default is _true_. If _false_ the validation will be disabled.

### validation_groups

By default, all constraints of selected class will be checked whether or not they actually pass. 
In some cases, however, you will need to validate an object against only some constraints on that class. 
To do this, you can organize each constraint into one or more "validation groups" and then apply validation against just one group of constraints.
