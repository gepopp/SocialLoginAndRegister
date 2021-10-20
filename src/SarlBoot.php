<?php

namespace SocialLoginAndRegister;


use SocialLoginAndRegisterClasses\SarlEnqueue;
use SocialLoginAndRegisterClasses\SarlRewriteRules;
use SocialLoginAndRegisterClasses\SarlAdminSettingsPage;

new SarlAdminSettingsPage();
new SarlRewriteRules();
new SarlEnqueue();
