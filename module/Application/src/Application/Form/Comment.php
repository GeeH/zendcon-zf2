<?php
namespace Application\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;

class Comment extends Form
{

    /**
     * @var InputFilter
     */
    protected $inputFilter;

    public function __construct()
    {
        parent::__construct('commentizr');

        $this->setAttribute('method', 'post');

        $this->setHydrator(new ClassMethods())
            ->setObject(new \Application\Model\Comment());

        $this->add(
            array(
                'name' => 'name',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Your name ',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'email',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Your email address ',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'comment',
                'attributes' => array(
                    'type' => 'textarea'
                ),
                'options' => array(
                    'label' => 'Comment ',
                ),
            )
        );

        $csrf = new Csrf();
        $csrf->setName('hash');
        $this->add($csrf);

        $this->add(
            array(
                'name' => 'referer',
                'attributes' => array(
                    'type' => 'hidden',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Add Coment',
                    'id' => 'submit',
                ),
            )
        );

    }

    public function getInputFilter()
    {
        if (is_null($this->inputFilter)) {
            $inputFilter = new InputFilter();


            $inputFilter->add(
                array(
                    'name' => 'name',
                    'required' => true,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim',
                        ),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'min' => 2,
                                'max' => 128,
                            ),
                        ),
                    ),
                )
            );

            $inputFilter->add(
                array(
                    'name' => 'email',
                    'required' => true,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim',
                        ),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'min' => 2,
                                'max' => 128,
                            ),
                        ),
                        array(
                            'name' => 'EmailAddress',
                        ),
                    ),
                )
            );

            $inputFilter->add(
                array(
                    'name' => 'comment',
                    'required' => true,
                    'filters' => array(
                        array(
                            'name' => 'StringTrim',
                        ),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'min' => 2,
                                'max' => 256,
                            ),
                        ),
                    ),
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

