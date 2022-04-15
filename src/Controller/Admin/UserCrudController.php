<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Self_;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName ): iterable
    {


        // Initialisation des caractères utilisables
//        $characters = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
//
//        for($i=0;$i<10;$i++)
//        {
//            $password= $i?($characters[array_rand($characters)]):$characters[array_rand($characters)];
//            $pass = implode("", );
//            var_dump($password);
//        }


        return [
            // IdField::new('id'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('pseudo'),
            TextField::new('password', 'password')->setDisabled(),
            TextField::new('phone'),
            TextField::new('email'),
            AssociationField::new('campus'),
            BooleanField::new('administrator'),
            BooleanField::new('activ'),
        ];
    }
}

