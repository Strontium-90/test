<?php

declare(strict_types=1);

namespace App\Tests\Form\Type;

use App\Entity\Book;
use App\Form\Type\BookType;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BookTypeTest extends TestCase
{
    /**
     * @test
     */
    function it_should_configure_form()
    {
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects($this->once())
                 ->method('setDefaults')
                 ->with([
                     'data_class' => Book::class,
                 ])
                 ->willReturnSelf()
        ;
        $type = new BookType();
        $type->configureOptions($resolver);
    }

    /**
     * @test
     */
    function it_should_build_form()
    {
        $builder = $this->createMock(FormBuilderInterface::class);
        $builder
            ->expects($this->exactly(2))
            ->method('add')
            ->withConsecutive(
                ['name', TextType::class],
                ['authors', EntityType::class]
            )
            ->willReturnSelf();

        $type = new BookType();
        $type->buildForm($builder, []);
    }
}
