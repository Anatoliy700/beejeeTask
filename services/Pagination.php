<?php


namespace app\Services;


use app\models\repositories\IRepository;
use Framework\Registry;
use Symfony\Component\HttpFoundation\Request;

class Pagination
{
    private const OFFSET = 'offset';
    private const PAGE = 'page';

    private $request;

    private $repository;

    private $limitItem;

    public function __construct(Request $request, IRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
        $this->limitItem = Registry::getDataConfig('limitTasks');
    }

    public function getLinks()
    {
        $links = [];

        for ($i = 1, $offset = 0; $i <= $this->getPageCount(); $i++, $offset += $this->limitItem) {
            $link = $this->getUrl([
                static::OFFSET => $offset,
                static::PAGE => $i
            ]);
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

    protected function getUrl($params = [])
    {
        $queryParams = array_merge($this->request->query->all(), $params);

        return Registry::getRoute($this->request->get('_route'), $queryParams);
    }

    protected function getPage()
    {
        return $this->request->get('page') ? (int)$this->request->get('page') : null;
    }

    public function render()
    {
        if ($this->getPageCount() < 2) {
            return '';
        }
        $str = '<nav aria-label="..."><ul class="pagination pagination-sm">';

        foreach ($this->getLinks() as $link) {
            $str .= $link;
        }

        $str .= '</ul></nav>';

        return $str;
    }
}
