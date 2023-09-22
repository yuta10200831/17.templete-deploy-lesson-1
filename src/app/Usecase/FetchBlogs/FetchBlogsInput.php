<?php
namespace App\Usecase\FetchBlogs;

use App\Domain\ValueObject\Order;
use App\Domain\ValueObject\Blog\BlogKeyword;

final class FetchBlogsInput
{
    /** @var Order|null */
    private ?Order $order;
    /** @var BlogKeyword */
    private BlogKeyword $keyword;

    /**
     * @param Order|null
     * @param BlogKeyword
     */
    public function __construct(?Order $order, BlogKeyword $keyword)
    {
        $this->order = $order;
        $this->keyword = $keyword;
    }

    /**
     * @return Order|null
     */
    public function order(): ?Order
    {
        return $this->order;
    }

    /**
     * @return BlogKeyword
     */
    public function keyword(): BlogKeyword
    {
        return $this->keyword;
    }
}
