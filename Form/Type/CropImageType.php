<?php

namespace Rares\ImageCropBundle\Form\Type;

use Rares\ImageCropBundle\Helper\ImageHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CropImageType extends AbstractType
{
	private ImageHelper $helper;


	public function setHelper(ImageHelper $helper): void
	{
		$this->helper = $helper;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('imageData', HiddenType::class, [
			'required' => FALSE,
		]);

		$builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) {
			$data = $event->getData();

			if ($data['file']) {
				$this->helper->cropImage($data['imageData'], $data['file']);
			}
		});
	}

	public function getBlockPrefix(): string
	{
		return 'rares_image_crop_crop_image';
	}

	public function getParent(): string
	{
		return VichImageType::class;
	}
}
