<?php


namespace app\Services;


use app\models\repositories\IRepository;
use Framework\Registry;
use Symfony\Component\HttpFoundation\Request;

class Pagination
{
    private $request;

    private $repository;

    private $limitItem;

    public function __construct(Request $request, IRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->limitItem = Registry::getDataConfig('limitTasks');

        $this->getOthersQueryParams();
    }

    public function getLinks()
    {
        $links = [];

        $path = $this->request->getPathInfo();

        for ($i = 1, $offset = 0; $i <= $this->getPageCount(); $i++, $offset += $this->limitItem) {
            if ($i === 1) {
                $link = $path;
                $link .= $this->getOthersQueryParams() ? '?' . $this->getOthersQueryParams() : '';
            } else {
                $link = "$path?offset={$offset}&page={$i}";
                $link .= $this->getOthersQueryParams() ? '&' . $this->getOthersQueryParams() : '';
            }
            $class = 'class="page-item';

            $page = $this->getPage();
            if ((!$page && $i === 1) || $i === $page) {
                $class .= ' active';
            }
            $class .= '"';
            {
                $links[] = "<li {$class}><a class=\"page-link\" href=" . $link . ">{$i}</a></li>";
            }
        }

        return $links;

    }

    protected function getPageCount()
    {
        return ceil($this->repository->getAmount() / $this->limitItem);
    }

    protected function getOthersQueryParams()
    {
        $pattern = "/offset=\d+&page=\d+/";
        $queryParams = preg_replace($pattern, '', $this->request->getQueryString());
        return trim($queryParams, '&');
    }

    protected function getPage()
    {
        return $this->request->get('page') ? (int)$this->request->get('page') : null;
    }

    public function render()
    {
        $str = '<nav aria-label="..."><ul class="pagination pagination-sm">';

        foreach ($this->getLinks() as $link) {
            $str .= $link;
        }

        $str .= ' </ul></nav>';

        return $str;
    }
}
