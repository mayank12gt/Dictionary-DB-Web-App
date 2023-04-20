<?php
require_once 'dbconn.php';
$searched_word =  trim($_GET["search"]," ");
$sql = "SELECT words.word_id,meaning_id,word,syllable_breakup,pronunciation,part_of_speech_id,description,example
         FROM words left join meaning on words.word_id=meaning.word_id where words.word='".$searched_word."'";

$result=$conn->query($sql);
if($result->fetchColumn()==0){
    exit($searched_word ." is not present in the dictionary" );}
else{
    foreach ($conn->query($sql) as $row) {
        
        $word_id= $row['word_id'];
        $word= $row['word'];
        $pos_id[]= $row['part_of_speech_id'];
        $syllable_breakup= $row['syllable_breakup'];
        $pronunciation= $row['pronunciation'];
        $description[]= $row['description'];
        $example[]= $row['example'];
        $meaning_ids[]=$row['meaning_id'];
    
    
        
       
    }

    $sql2 = "SELECT scientific_name,image
         FROM biological_word where word_id='".$word_id."'";

$result2=$conn->query($sql2);
$scientific_name;
$image;
if($result2->fetchColumn()==0){
    
    }
else{
    foreach ($conn->query($sql2) as $row) {
        $scientific_name=  $row['scientific_name'];
         $image= $row['image'];
    }
    
}



foreach($pos_id as $pos1){
$sql3 = "SELECT part_of_speech_tag
FROM part_of_speech where part_of_speech_id='".$pos1."'";

$result3=$conn->query($sql3);
$pos;
if($result3->fetchColumn()==0){

}
else{
foreach ($conn->query($sql3) as $row) {
$pos[]=  $row['part_of_speech_tag'];

}

}


}

$synonyms=array();
foreach($meaning_ids as $meaning_id ){
$sql4 = "SELECT synonym_id
FROM synonym where meaning_id='".$meaning_id."'";


$result4=$conn->query($sql4);
$pos;
if($result4->fetchColumn()==0){

}
else{
foreach ($conn->query($sql4) as $row) {
$synonym_ids[]=  $row['synonym_id'];

}

foreach ($synonym_ids as $synonym_id) { 

$sql5 = "SELECT word
FROM words where word_id='".$synonym_id."'";
$result5=$conn->query($sql5);

if($result5->fetchColumn()==0){

}
else{
foreach ($conn->query($sql5) as $row) {
$synonyms[]=  $row['word'];

}


}



}
}
}





$antonyms=array();
foreach($meaning_ids as $meaning_id ){
$sql9 = "SELECT antonym_id
FROM antonym where meaning_id='".$meaning_id."'";


$result9=$conn->query($sql9);
if($result9->fetchColumn()==0){

}
else{
foreach ($conn->query($sql9) as $row) {
$antonym_ids[]=  $row['antonym_id'];

}

foreach ($antonym_ids as $antonym_id) { 

$sql10 = "SELECT word
FROM words where word_id='".$antonym_id."'";
$result10=$conn->query($sql10);

if($result10->fetchColumn()==0){

}
else{
foreach ($conn->query($sql10) as $row) {
$antonyms[]=  $row['word'];

}
}
}
}
}






$sql6 = "SELECT hindi_word
FROM lang_hindi where word_id='".$word_id."'";
$result6=$conn->query($sql6);

if($result6->fetchColumn()==0){

}
else{
foreach ($conn->query($sql6) as $row) {
$hindi_translation[]=  $row['hindi_word'];

}


}

$sql6 = "SELECT gujrati_word
FROM lang_gujrati where word_id='".$word_id."'";
$result6=$conn->query($sql6);

if($result6->fetchColumn()==0){

}
else{
foreach ($conn->query($sql6) as $row) {
$gujrati_translation[]=  $row['gujrati_word'];

}


}


$sql7 = "SELECT bengali_word
FROM lang_bengali where word_id='".$word_id."'";
$result7=$conn->query($sql7);

if($result7->fetchColumn()==0){

}
else{
foreach ($conn->query($sql7) as $row) {
$bengali_translation[]=  $row['bengali_word'];

}


}











}

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles2.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500&display=swap" rel="stylesheet">
    <title>Dictionary</title>
    
</head>
<body>
    <div id="outerdiv">
        <div id="innerdiv">
    <label class="word_heading"> 
        <?php  echo $word?> 
    </label>
    <br>
    <br>


        <label class="word_syllable"> 
            <?php  echo $syllable_breakup."\t"?>  </label>
            
            
    <label class="scientific_name"> 
        <?php if(isset($scientific_name)){ echo $scientific_name;}?>
        </label>
        <br>
        <br>

        <div class="pronunciation">
        <img class="x"  src="icons8-speak-24.png"/> 
        <label class="x" >
        <?php  echo $pronunciation?>
        </label>
        </div>
        

        
         <br>
         

       

     
     
     

     
  
    <label >
          <?php
             for ($x = 0; $x < sizeof($description); $x++) {
                echo "<div class=meaninglabel>";
                echo "<span class=heading>";
                echo "Meaning ".$x+1 .": ";
                echo"</span>";
                echo"<span class=subheading>";
                echo "(".$pos[$x].") "; 
                echo"</span>";
               echo $description[$x]; 
               echo "<br>";
               echo "<br>";
               echo"<span class=heading>";
               echo "Example : ";
               echo"</span>";
               echo $example[$x];
               echo "<br>";
               echo "<br>";
               echo"<span class=heading>";
               echo "Synonyms: ";
               echo"</span>";
               if(!empty($synonyms[$x])){
               
               
               for($j=0;$j<sizeof($synonyms);$j++){
                echo $synonyms[$j];
                if(sizeof($synonyms)-$j>1){
                    echo ",";
                }
               }

               }
                echo "<br>";
                echo"<span class=heading>";
                echo "Antonyms: ";
                echo"</span>";
               if(!empty($antonyms[$x])){
               
                
                for($j=0;$j<sizeof($antonyms);$j++){
                 echo $antonyms[$j];
                 if(sizeof($antonyms)-$j>1){
                     echo ",";
                 }
                }
 
                }
                echo "</div>";
                echo "<br>";

               
              }

            
            ?>

    </label>
    
    


<label style="margin-left:1.2rem; font-weight:900;font-size:1.5rem;" class="heading">In other Languages:</label>
<br>
<br>
<div class="lang" style="font-size:1.1rem;">
<label><span class="heading">Hindi:</span></label>
<label>
    <?php
    if(!empty($hindi_translation)){
for($j=0;$j<sizeof($hindi_translation);$j++){
                 echo $hindi_translation[$j];
                 if(sizeof($hindi_translation)-$j>1){
                     echo ", ";
                 }
                }  
            }  
                ?>
</label>

<br>

<label><span class="heading">Gujrati:</span></label>

<label>
    <?php
    if(!empty($gujrati_translation)){
for($j=0;$j<sizeof($gujrati_translation);$j++){
                 echo $gujrati_translation[$j];
                 if(sizeof($gujrati_translation)-$j>1){
                     echo ", ";
                 }
                }  
            }  
                ?>
</label>
<br>

<label><span class="heading">Bengali:</span></label>
<label>
    <?php
    if(!empty($bengali_translation)){
for($j=0;$j<sizeof($bengali_translation);$j++){
                 echo $bengali_translation[$j];
                 if(sizeof($bengali_translation)-$j>1){
                     echo ", ";
                 }
                }  
            }  
                ?>
</label>

</div>

<br>
</div>

<div id="imagediv">
        <label> 
        
        <?php if(isset($image)){
        echo '<img src="data:image/jpeg;base64,' . base64_encode($image).'">';
        }?>
         </label>
        </div>

</div>





    


    
</body>
</html>