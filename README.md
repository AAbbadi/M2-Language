# Magento 2 test

The code was implemented to solve an issue when the magento store is multi store, and there is a shared CMS pages, then this will cause a duplicate content issue and will affect the SEO ranking.

# How to use
Copy Test\Duplicate folder to DOC_ROOT/app/code/ use SSH to access the server and execute the following commands in DOC_ROOT

1. php bin/magento setup:upgrade
2. php bin/magento setup:di:compile
3. php bin/magento c:c ----> to clear cache if needed

Then, Login to admin panel, Click on Stores -> Settings -> Configuration -> General you will be able to find a new section named as Store Language, select the store that you want to change the language for then save the config.
