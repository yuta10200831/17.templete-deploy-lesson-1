<?php
namespace App\Domain\ValueObject\User;

use Exception;

final class UserName
{
    const MAX_LENGTH = 20;
    const INVALID_MESSAGE = 'お名前は20文字以内でご入力ください。';

    private string $value;

    public function __construct(string $value)
    {
        if ($this->isInvalid($value)) {
            throw new Exception(self::INVALID_MESSAGE);
        }
        $this->value = $value;
    }

    /**
     * Value値を取得
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Value値のバリデーション
     * @param string $value
     * @return bool
     */
    private function isInvalid(string $value): bool
    {
        return mb_strlen($value) > self::MAX_LENGTH;
    }
}
