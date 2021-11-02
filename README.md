# bodmin

It is essentially a tailor made CMS for bird observatories, or a bird observatory "system". The system contains back-end data management workflow modules coupled with a front-end web site. Everything sits under a common (HTML) root. 

The system is built using PHP in the back-end, with (over time) increasing use of JQuery and JavaScript. PHP is now mainly used to create the basic HTML page (which the Java Script is operating upon) and to ship data from and to the DB using JSON. Beyond JQuery, a number of extra js libraries are used. Of course Bootstrap, but also others.

A simple PHP class, PageMetaData is used for maintaining the CSS and JS sections of a page (including the order in which these files are specified). 


No framework is used. This is intentional, with the motivation that "anyone" with knowledge of Javascript and PHP should be able to amend and change the code base.
