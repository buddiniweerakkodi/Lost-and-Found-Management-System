<?php
interface PasswordChangerInterface {
    public function verifyCurrentPassword($userId, $currentPassword);
    public function updatePassword($userId, $newPassword);
}
?>
