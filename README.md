# bodmin

It is essentially a tailor made CMS for bird observatories, or a bird observatory "system". It contains back-end data management workflow modules coupled with a front-end web site. Everything sits under a common (HTML) root. 

<h2>What about the name?</h2>
It was initially, due to lack of fantasy "boadmin", bird observatory administrative system". Later, after interacting with Stephen Menzie being Brit, the idea of referring to bodin (the famous "monster") came up. It stuck.

<h2>Short technical overview</h2>
<p>A normal out-of-the-box XAMPP installation is used. Data is kept in a MariaDB instance that comes with the installation. Production system is run on a CPANEL instance.</p>
<p>The system is built using PHP in the back-end, with (over time) increasing use of JavaScript and JQuery. PHP is now mainly used to create the basic HTML page (which the Java Script is operating upon) and to ship data from and to the DB using JSON. Beyond JQuery, a number of extra js libraries are used. Of course Bootstrap, but also others.</p>

<p>A simple PHP class, PageMetaData, is used for maintaining the CSS and JS sections of a page (including the order in which these files are specified).</p>

<p>No framework is used. This is intentional, with the motivation that "anyone" with knowledge of Javascript and PHP should be able to amend and change the code base.</p>
