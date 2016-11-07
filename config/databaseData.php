<?php

return <<<'data'
INSERT INTO `universities` VALUES (NULL, 'University 1', 'Cherkassy', 'http://u1.com');
INSERT INTO `universities` VALUES (NULL, 'University 2', 'Kyiv', NULL);
INSERT INTO `universities` VALUES (NULL, 'University 3', 'Odessa', 'http://u3.com');

INSERT INTO `departments` VALUES (NULL, 'Dep 1', 1);
INSERT INTO `departments` VALUES (NULL, 'Dep 2', 1);
INSERT INTO `departments` VALUES (NULL, 'Dep 3', 1);
data;
