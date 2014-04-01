  Moodle 2.3 plugin: EasyOChem Structure Display (EasyOStructure) question type

IMPORTANT:

Chemaxons Marvin Appets are used in this question type.  We do not provide 
the Marvin applets, so you must apply for a license and download on your own.  
A FreeWeb Licenses is available for educational, non commercial, freely accessible web pages. 

The PHP scripts which accompany the editor are open-source under the 
GNU Public Licence (GPL) - the same licence as Moodle.


INSTALLATION:

This will NOT work with Moodle 2.0 or older, since it uses the new
question API implemented in Moodle 2.1.

1) Install marvin applets on you server by downloading the "Marvin 
for Web Developers" at http://www.chemaxon.com/download/marvin/for-web-developers/  
Install at your web servers root in folder named "marvin".  If you don't want 
to or can't install at root you can modify the module.js and edit_marvin_form.php 
to point toward your marvin installation. 

2) This is a Moodle question type. It came as a self-contained 
"easyostructure" folder which should be placed inside the "question/type" folder
which already exists on your Moodle web server.

3) Place the customization_mech_instructor.xml MarvinSketch customization file 
in your marvin installation directory you .  

Once you have done that, visit your Moodle admin page - the database 
tables should automatically be upgraded to include an extra table for
the EasyOMech question type.


USAGE:

The EasyOChem 2D/3D Structure Display question type (EasyOStructure) is a short answer 
question with MarvinSketch for building question content and MarvinView for 
displaying question content.  Anything that you can construct in MarvinSketch 
can be easily used in short answer questions.  You can choose from three different 
representations for your chemistry content in MarvinSketch; line bond, normal 
(Lewis structure like) and 3D Ball and Stick.  Structures can be optimized in 2D and 3D
and displayed as question data.  You can ask questions such as "Are the two chlorine groups 
in the following structure cis or trans?"  or "What is the name of the following 
reaction?" or Does this structure have R(E) or S(Z) stereochemistry?  


