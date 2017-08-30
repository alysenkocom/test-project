# Test application

## NOTE

If you have any questions or something is unclear feel free to create an issue ![here](https://github.com/runashop/test-project/issues)

## Description

Picture hosting site with ability to create albums and upload pictures to them. Each picture should be saved as original file and two thumbnails should be created: 100p, 360p and 720p. Thumbnails should be created only if original picture is bigger then thumbnail size.

1. Index page: ![Index page](http://joxi.net/Vrw8OR9sO3z8Ym.jpg)
1. Upload page: ![Upload page](http://joxi.net/DmBLpw0SwYQj3A.jpg)
1. Album page: ![Album page](http://joxi.net/DmBLpw0SwYQ83A.jpg)
1. Picture page: ![Picture page](http://joxi.net/a2XZpLGs1WdMKr.jpg)

## Requirements

1. This should work on PHP not less then 5.6
1. You can choose any PHP framework
1. You can use any JS framework
1. PHP frameworks and libraries **MUST** be added via Composer - no source codes here
1. JS frameworks and libraries **MUST** be added via npm or bower - no source code here
1. DB is MySQL/PostgreSQL. No NoSQL
1. Pictures resizing should be performed in the background. Use daemon for this. Queue could be organized in DB (for simplification) or you can use any major queue software: Rabbit, Apache, beanstalkD, etc.

## How to start working

1. Fork this repo
1. Push your code
1. Create pull-request
1. ...
1. PROFIT!
