<?php

namespace PhilipBrown\ThisIsBud\Decryption;

class DataDecryptionService
{
    public function decrypt(Message $inputJson): Message
    {
        $encryptedTextCell = $inputJson->getCell();
        $plainTextCell = $this->decryptString($encryptedTextCell);

        $encryptedTextBlock = $inputJson->getBlock();
        $plaintextBlock = $this->decryptString($encryptedTextBlock);

        return Message::fromCellAndBlock($plainTextCell, $plaintextBlock);
    }

    private function decryptString(string $encryptedtext): string
    {
        $encryptedTextCharacters = explode(' ', $encryptedtext);

        $decryptCharacter = function (string $encryptedCharacter): string {
            return chr(bindec($encryptedCharacter));
        };

        $plaintextCharacters = array_map($decryptCharacter, $encryptedTextCharacters);

        return implode('', $plaintextCharacters);
    }
}
