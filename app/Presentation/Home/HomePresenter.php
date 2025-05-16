<?php

declare(strict_types=1);

namespace App\Presentation\Home;

use Nette;
use App\Model\PostFacade;

final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(private PostFacade $postFacade) {}

    public function renderDefault(): void
    {
	    $this->template->posts = $this->postFacade
		    ->getPublicArticles()
		    ->limit(5);
    }
}
