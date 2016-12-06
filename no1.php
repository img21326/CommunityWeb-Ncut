<html>
    <head>
     <title>

     </title>
     <style>
      .header{
       height: 500px;
       width:  500px;
       background: red;
       /* padding-top: 50px;<=內推   外推=>c
       padding-right: 50px;*/
       margin-left:auto ;/* 移到中間*/
       margin-right: auto;
      }
      .box1{
        height: 100px;
        width:  100px;
        background: blue;
        margin-top: 50px;
        margin-left: 50px;
        float:left;
       -webkit-border-radius: 15px;
       -moz-border-radius: 15px;
       border-radius: 15px;
       }
      .box2{
       height: 100px;
       width:  100px;
       background: blue;
       margin-top: 50px;
       margin-left: 50px;
       float:left;
       -webkit-border-radius: 15px;
       -moz-border-radius: 15px;
       border-radius: 15px;
      }
      .clear{
       clear: both;
      }
      .box3{
       height: 100px;
       width:  100px;
       background: blue;
       margin-top: 50px;
       margin-left: 50px;
       -webkit-border-radius: 15px;
       -moz-border-radius: 15px;
       border-radius: 15px;
      }

     </style>

    </head>


    <body>
      <div class = "header">

       <div class = "box1">
        <center> box1</center>
       </div>
       <div class = "box2">
        <center> box2</center>
       </div>
       <div class = "clear">

       </div>
       <div class = "box3">
        <center> box3</center>
       </div>

      </div>

     </body>



</html>
