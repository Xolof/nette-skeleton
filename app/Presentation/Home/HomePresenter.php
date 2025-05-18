<?php

declare(strict_types=1);

namespace App\Presentation\Home;

use Nette;
use App\Model\PostFacade;
use App\Presentation\Accessory\Markdowner;

final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(private PostFacade $postFacade)
    {
    }

    public function renderDefault(): void
    {
        $postsFromDb = $this->postFacade
            ->getPublicArticles()
            ->limit(5);

        $markdowner = new Markdowner();

        $posts = [];

        foreach ($postsFromDb as $post) {
            $posts[] = [
                "id" => $post->id,
                "title" => $post->title,
                "created_at" => $post->created_at, // phpcs:ignore
                "content" => $markdowner->print($post->content)
            ];
        };

        $this->template->posts = $posts;
    }
}
