<?php
echo "Admin hash: " . password_hash('admin', PASSWORD_DEFAULT) . "\n";
echo "User hash (123456): " . password_hash('123456', PASSWORD_DEFAULT) . "\n";
