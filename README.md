# YOMI
Final Year Project - Degree

1.Paste 'YOMI' folder in C:\wamp64\www folder.

2.RUN Wampserver64

3.Enter http://localhost/phpmyadmin/ on browser

4.Create yomi database.

5.import yomi.sql to yomi database.


NOTE: After sucessfully importing 'yomi.sql' to database, open 'sql' tab in mysql and paste the following SQL statements:-


CREATE USER 'root'@'%' IDENTIFIED BY 'PASSWORD';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;



*IF ABOVE STATEMENTS IS NOT RUN, SOME FUNCTIONS WILL NOT BE ABLE TO BE USE SUCH AS 'PRODUCT SUGGESTIONS' & 'ADD TO CART FUNCTION' ON PRODUCT PAGE!

6.Enter http://localhost/YOMI/homepage.php on Chrome.




admin login
username: admin
password: esq165


user's login
username for users can check on database.
all users password is 'esq165' which is same with admin's

