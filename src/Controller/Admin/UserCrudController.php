<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\Types\Self_;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;


class UserCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    function Genere_Password($size)
    {
        // Initialisation des caractères utilisables
        $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $password='';
        for($i=0;$i<$size;$i++)
        {
            $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
        }

        return $password;
    }

    public function configureFields(string $pageName ): iterable
    {

        $pass = $this->Genere_Password(10);

        return [
            // IdField::new('id'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('pseudo'),
            HiddenField::new('password','password')->setFormTypeOptionIfNotSet('data', $pass),
            TextField::new('phone'),
            TextField::new('email'),
            AssociationField::new('campus'),
            BooleanField::new('administrator'),
            BooleanField::new('activ'),
        ];
    }
}

