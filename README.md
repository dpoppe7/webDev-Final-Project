# webDev-Social-Networking-Project

This project develops a social networking website that works similar to Facebook. I practiced using, **HTML, CSS, Javascript and PHP** scripts that interact with a database, implement user authentication, and use sessions. The **database** we used called taz is orovided by my school (Harding University) for computer science students. 

The **DEMO** for this website:
http://taz.harding.edu/~dpoppe/myfacespace/login.php

In this prject you can:
+ Create an Account (your name and username will be saved in the database)
+ Login into your account
+ See your profile (displays your picture name and status)
+ Edit your profile (modify your password or picture)
+ Update status, similar to facebook you can post and update your status to be displayed in your profile
+ Add friends (All accounts saved in the database will be shown) The friends that you add are displayed in your profile
+ Remove friends (Friends removed will not be shown in your profile anymore but you can add them again)
+ Log out

## About this Project
### Scripts

The system is composed of several scripts:
1. login.php – Handles logging in existing users.
2. create_account.php – Creates a new account for new users
3. edit_account.php – Edits account of existing users
4. index.php – The main page that shows the user’s complete profile and a list of their friends
5. set_status.php – Sets the user’s status in the database
6. add_friends.php – Searches for friends
7. add_friend_db.php – Adds a friend to the database
8. remove_friend_db.php – Removes a friend from the database
9. logout.php – Logs user out

### Database Setup

The project stores all data in my MySQL database on Taz. The following tables are created in my database:

1. account – Stores the information for each user along with bcrypt password hash<br/>
CREATE TABLE account ( <br/>
&nbsp; &nbsp; &nbsp; username varchar(45) NOT NULL,<br/>
&nbsp; &nbsp; &nbsp; password varchar(80) NOT NULL,<br/>
&nbsp; &nbsp; &nbsp; name varchar(100) NOT NULL,<br/>
&nbsp; &nbsp; &nbsp; status varchar(250) NOT NULL,<br/>
&nbsp; &nbsp; &nbsp; updatetime datetime default NULL,<br/>
&nbsp; &nbsp; &nbsp; PRIMARY KEY (username)<br/>
);


2. friend – Stores the usernames of friend relationships (1 row = 1 friendship)<br/>
CREATE TABLE friend (<br/>
&nbsp; &nbsp; &nbsp; username1 varchar(45) NOT NULL,<br/>
&nbsp; &nbsp; &nbsp; username2 varchar(45) NOT NULL,<br/>
&nbsp; &nbsp; &nbsp; PRIMARY KEY (username1, username2)<br/>
);<br/><br/>

Also, I used INSERT queries to insert some users into the account table. Each user’s password is the same as their username.<br/><br/>
INSERT INTO account VALUES (<br/>
&nbsp; &nbsp; &nbsp; 'bsmith',<br/>
&nbsp; &nbsp; &nbsp; '$2y$10$pvZhpc4i5fstLBCz7p1/p.5.Uv7JrNIjJ8hxaAICz1fk/YiDVWibO',<br/>
&nbsp; &nbsp; &nbsp; 'Bob Smith',<br/>
&nbsp; &nbsp; &nbsp; 'Enjoying the sun!', '2020-03-16 13:03:00'<br/>
);<br/>

INSERT INTO account VALUES (<br/>
&nbsp; &nbsp; &nbsp; 'sblack', <br/>
&nbsp; &nbsp; &nbsp; '$2y$10$i8fsnV3xLNXJawIjJLPZP.J9b4F6pumVCcfaoqfZoHx2875xhZlf.',<br/>
&nbsp; &nbsp; &nbsp; 'Sue Black',<br/>
&nbsp; &nbsp; &nbsp; 'Spring Break next week!!',<br/>
&nbsp; &nbsp; &nbsp; '2020-03-09 08:16:00'<br/>
);<br/>

Here is the full description fo the project: https://sites.harding.edu/fmccown/classes/comp2500-s20/MyFaceSpace.pdf


