<?php

declare(strict_types=1);

namespace designerei\ContaoLayoutBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'miscellaneous', template: 'content_element/layout', nestedFragments: true)]
class LayoutController extends AbstractContentElementController
{
    public function __construct(
        private readonly ContaoFramework $framework)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $nestedFragments = [];

        foreach ($template->get('nested_fragments') as $i => $reference) {
            $nestedModel = $reference->getContentModel();

            if (!$nestedModel instanceof ContentModel) {
                $nestedModel = $this->framework->getAdapter(ContentModel::class)->findById($nestedModel);
            }

            $nestedModel->nestedInLayout = 1;
            $nestedModel->parentLayoutType = $model->layoutType;

            $nestedFragments[$i] = $reference;
        }

        $template->set('nested_fragments', $nestedFragments);

        return $template->getResponse();
    }
}