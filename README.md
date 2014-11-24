<h1>Personal Project : Password Security</h1>

<h2>Background</h2>



<p>My personal project is actually comprised of two individual elements with a unifying theme: data security. Growing up, the web was always a fascinating place for me and I always specifically had a great deal of interest for dynamic websites – those who used databases on their backend to provide more value (or fun as it may be with the games when I was younger). </p>

<p>Many of games I played were writing-based or at least had a community component behind them. Several utilized the open source platform phpBB to provide message board and login functionality for the games. As I got older I began exploring web development more and bought my own web hosting plan so that I could upload phpBB to a server and see how everything was working. At that time, I had no programming background so the PHP was beyond my understanding – but I always found comfort in that I could use phpmyadmin to see how all of the information from the message board was stored and how the database helped everything come together. 
phpBB2 was the most up to date  version at that time – and it had some security related issues. This lead to my websites I had created for friends to come and keep in touch on, to be hacked. One vulnerability that exited in phpBB2 was that passwords were only hashed with md5 – which was proven ineffective. This got me interested in data security. </p>

<p>How this became my capstone individualized project is as follows: </p>

<p>When the team first began work on Smockish and I was asked to design the schema for the database I asked Twayne, who was functioning as the team’s most experienced coder, how large I should make the password field to accommodate whatever hash he would be using, he was unclear what I was talking about. In CIS 425 password security is not taught – passwords are stored in the database as plain text strings. Thus, figuring out how best to handle password security became my personal project. </p>

<p>Because my knowledge of these topics at the beginning was limited to the fact that they are important considerations, but not how to implement them, and due to the fact that is often very dangerous to be “creative” with security – this personal project will be a showcase of what I learned in the areas of password security as opposed to any innovative work in the area. </p>

<h2>Password Security </h2>

<p>Password security is very important. As we have seen in the news, it is not uncommon for businesses to have data breaches and for hackers to wind up with the information in a website's database. This means it is important to protect user security in the instance when hackers already have their data. For passwords this typically comes in the form of hashing passwords with a cryptographic hashing algorithm. What this does is give you a unique string which identifies the password and can be securely stored. When a user enters their password, you hash it and compare it to the hash stored in the database. If they match the user has successfully provided the password – if they do not, then the user has not successfully entered the correct password. </p>

<h3>Shortfalls of Hash Only Systems </h3> 

<p>While hashing adds some security in the instance that hackers get ahold of your database, alone hashing can be attacked with brute-force attacks and lookup tables. Brute force attacks will always eventually figure out a hashed password because it involves simply hashing every possible password until the resulting hash matches one of the hashed passwords in the database. However, with sufficiently long passwords brute force becomes a negligible problem due to the amount of time it would take. Look up tables are the larger concern.</p>

<h4>Look Up Tables</h4>
<p>These tables consist of previously computed hashes of common words and passwords and the hacker simply matches the hashed passwords from your database to his lookup table until he finds someone with a password he has pre-computed and can exploit.</p>

<p>For example consider a look up table of: </p>

<table>
	<tr>
		<td><b>Password</b></td>
		<td><b>Sha256 Hash</b></td>
	</tr>
	<tr>
		<td>123456</td>
		<td>8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92</td>
	</tr>
	<tr>
		<td>password</td>
		<td>5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8</td>
	</tr>
	<tr>
		<td>12345678</td>
		<td>ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f</td>
	</tr>
	<tr>
		<td>qwerty</td>
		<td>65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5</td>
	</tr>
	<tr>
		<td>abc123</td>
		<td>6ca13d52ca70c883e0f0bb101e425a89e8624de51db2d2392593af6a84118090</td>
	</tr>
	<tr>
		<td>123456789</td>
		<td>15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225</td>
	</tr>
	<tr>
		<td>111111</td>
		<td>bcb15f821479b4d5772bd0ca866c00ad5f926e3580720659cc80d39c9d09802a</td>
	</tr>
	<tr>
		<td>1234567</td>
		<td>8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414</td>
	</tr>
	<tr>
		<td>iloveyou</td>
		<td>e4ad93ca07acb8d908a3aa41e920ea4f4ef4f26e7f86cf8291c5db289780a5ae</td>
	</tr>
	<tr>
		<td>adobe123</td>
		<td>923783d62d262107202f1d290871b5a5dfc7fc75ee3a9a0869ecba42650b45aa</td>
	</tr>
	<tr>
		<td>123123</td>
		<td>96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e</td>
	</tr>
	<tr>
		<td>admin</td>
		<td>8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918</td>
	</tr>
	<tr>
		<td>1234567890</td>
		<td>c775e7b757ede630cd0aa1113bd102661ab38829ca52a6422ab782862f268646</td>
	</tr>
	<tr>
		<td>letmein</td>
		<td>1c8bfe8f801d79745c4631d09fff36c82aa37fc4cce4fc946683d7b336b63032</td>
	</tr>
	<tr>
		<td>photoshop</td>
		<td>3f4a09b92ccf3382d71c8e3937b06b7945c6f1e42338d3f7e4c8577f220d810b</td>
	</tr>
	<tr>
		<td>1234</td>
		<td>03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4</td>
	</tr>
	<tr>
		<td>monkey</td>
		<td>000c285457fc971f862a79b786476c78812c8897063c6fa9c045f579a3b2d63f</td>
	</tr>
	<tr>
		<td>shadow</td>
		<td>0bb09d80600eec3eb9d7793a6f859bedde2a2d83899b70bd78e961ed674b32f4</td>
	</tr>
	<tr>
		<td>sunshine</td>
		<td>a941a4c4fd0c01cddef61b8be963bf4c1e2b0811c037ce3f1835fddf6ef6c223</td>
	</tr>
	<tr>
		<td>12345</td>
		<td>5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5</td>
	</tr>
</table>

<p>The above are the most common passwords of 2013. Source: http://splashdata.com/press/worstpasswords2013.htm</p>

<br />

<p>If this table was used against the current passwords in Smockish database (if they were hashed in sha256): </p>

<table>
	<tr>
		<td><b>User</b></td>
		<td><b>Hash</b></td>
		<td><b>Compromised Password</b></td>
	</tr>
	<tr>
		<td>user1</td>
		<td>a4e3c20a327766600f2e45b9b0735d26e2f809088dd323d7a5ad5d71d757dc69</td>
		<td>??</td>
	</tr>
	<tr>
		<td><b>user2</b></td>
		<td><b>5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5</b></td>
		<td><b>12345</b></td>
	</tr>
	<tr>
		<td>user3</td>
		<td>f969fdbe811d8a66010d6f8973246763147a2a0914afc8087839e29b563a5af0</td>
		<td>??</td>
	</tr>
	<tr>
		<td><b>user4</b></td>
		<td><b>5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5</b></td>
		<td><b>12345</b></td>
	</tr>
	<tr>
		<td><b>user5</b></td>
		<td><b>5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8</b></td>
		<td><b>password</b></td>
	</tr>
	<tr>
		<td>user6</td>
		<td>01a7c863763a49beecedd8c935187fdbfcebded36dc8f38fee1c77316c8d26ba</td>
		<td>??</td>
	</tr>
</table>

<p>We were purposefully using weak passwords because we were well aware that we were storing them as plain text for a majority of the semester but this still does well to show the weakness of simply hashing passwords. It takes a little work, but it is very easy to match up hashes from a large dictionary of pre-computed hashes and a compromised database.  </p>

<p>Further, without salts every user with the same password will be easily identified by comparing the hashes to one another because each string has a unique hash which identifies it and only it. </p>

<h4>Adding A Salt</h4>
 
<p>Look up tables are combated with the use of a salt. A salt is a unique string you add to a password before hashing it that makes it more challenging to create lookup tables. Some use a single hash for the entire website – this at least requires the hacker to create a new lookup table that correctly adds your salt before hashing. However, the best practice is to use a unique hash for each individual every time they modify their password. This means that lookup tables are impractical to create because a hacker would have to add each individual’s salt to the passwords he wanted to check and essentially create a lookup table for each individual using their unique salt.</p>

<table>
	<tr>
		<td><b>Password</b></td>
		<td><b>Salt</b></td>
		<td><b>Hash</b></td>
	</tr>
	<tr>
		<td>roots</td>
		<td>58fd828b223789731cd555d3574151ad75a6c751</td>
		<td>149517a6f1adaab8ced5721b853fe8dad49df7cd890d6005eac8d939fee46463</td>
	</tr>
	<tr>
		<td>12345</td>
		<td>e7ff7d0563d1493438838689329d6642901fbda0</td>
		<td>cf73edf192683882e6fb5d1137a54db63b762e6c598e8d67dfbb25b39d7fa917</td>
	</tr>
	<tr>
		<td>asdfg</td>
		<td>b6c28b807050ba7bdc533561780d43af6dbf0ce8</td>
		<td>50deb1ae076a04ec112fcd7f0dd16a02192d66ea2da6a7a9b99426bc199abe3c</td>
	</tr>
	<tr>
		<td>12345</td>
		<td>06b364b621e6103b4c66e6d816ba848bd7c8f195</td>
		<td>10eefec6bf6d170e8e6c7c45cc55e939e1420f4308734d1966fffc0d34d5ddbf</td>
	</tr>
	<tr>
		<td>password</td>
		<td>c5a33789a815a983937119cc8394fa02ef8353ed</td>
		<td>0163a37e81f5741989dabbcbd47bcc3c5ee696202a35af074659f5b6d46af751</td>
	</tr>
	<tr>
		<td>mayrag</td>
		<td>e5fb5e3b62ae2b79a1fceac04e4710aff277ad70</td>
		<td>a283f60e718da0ce0d14230f525b0d572c8ceace65a0be8be471e649e4cbd5b1</td>
	</tr>
</table>

 	

 
 

 





























 