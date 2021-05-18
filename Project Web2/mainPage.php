<?php
    session_start();

    if (!isset($_SESSION["user"])){
        $_SESSION["error"] = "Unauthorized user";
        header ("Location: ./index.php");
        exit;
    }

    $user = $_SESSION["user"];
    #var_dump($user);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Title of the document</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
        .slashed{
            text-decoration: line-through;
        }
        body, html{
            height: 100%;
        }
        .container{
            width: 100%;
            height: 100%;
        }
        section{
            height: 100%;
        }

        .italic{
            font-style: italic;
        }
        .lists{
            margin-top: 50px;
            list-style: none;
        }
        li a{
            text-decoration: none;
            color: black;
            padding: 10px ;
            width: 90%;
            margin: 10px auto 10px ;
        }
    
        .item-field{
            border-radius: 10px;
            padding: 0px 5px;
            color: white;
        }

        section.main{
            display: flex;
            flex-direction: column;
        }
        article{
            flex-grow: 1;
        }

        .add{
            width: 10%;
        }

        .hide{
            display: none;
        }
        h3{
            margin: 20px;
        }
        .item-card{
            width: 90%;
            height: 50px;
            font-size: 20px;
            margin: 10px auto;
            padding: 10px;
            border-radius: 10px;
            color: black;
        }
        .user-view{
            margin: 10px
        }
        td{
            padding: 0px;
        }

    </style>
  </head>
  <body>
    <div class="container row">
        <section class = "sideNav col s4">
           
            <div class="user-view">
                
                    <table>
                    <tr>
                        <td><img src="./images/<?=$user["file"]?>" alt="" class="circle" width="50px" height="50px"></td>
                        <td>  
                            <div id="name"><?= $user["name"]?></div>
                            <div id="email"><?= $user["email"]?></div>
                        </td>
                        <td class = "logout"> <a href="./logout.php"><i class="material-icons">exit_to_app</i></a></td>
                    </tr>
                </table>
            </div>
        
        
            <div class="lists">
                
                <li>
                    <a id="impo" href="#" class="waves-effect"><i class="left material-icons">star_border</i>Important</a>
                </li>
                <li><div class="divider"></div></li>
            
                <ul id="allLists">
                    
                </ul>
               
                <li>
                    <a href="#modal1" class="italic waves-effect modal-trigger">
                        <i class="left material-icons">add</i> New List
                    </a>
                </li>
            </div>

        </section>


        <section class = "main col s8  teal lighten-2 white-text">
            
            <article id="mainbody">
            </article>

            <div id="itemBox" class="hide">
                <form id="itemform">
                    <div class="input-field item-field grey">
                        <table>
                            <tr>
                                <td width = "10%"><i class="material-icons medium">add</i></td>
                                <td>
                                    <input name = "item" id="itemEnter" type="text" class="validate" placeholder="Enter an item...">
                                </td>
                            </tr>
                        </table>

                    </div>
                </form>
            </div>

        </section>

        
    </div>
    
    <div id="modal1" class="modal">
        <div class="modal-content">
            <form action="" id="listForm">
                <div class="input-field row">
                <input class="col s10" name="listname" id="listname" type="text" class="validate" placeholder="Enter list name..">
                </div>
            </form>
        </div>

    </div>
    
    
    
 <script>  
        
    $(function(){

        var email = $('#email').html();
        $('.modal').modal();

        getLists();
        
        console.log(email);

        function getLists(){
            console.log(email);
 
            $.get("lists.php", {email : email}, function(data){
                rows = "";

                for (let list of data){
                    rows += `
                            <li id="${list.list}" class="thing">
                                <a href="#" class="waves-effect">
                                    <i class="left material-icons">menu</i> ${list.list}
                                </a>
                            </li>
                    `;
                }                    
                $('#allLists').html(rows);
            })
        }
        $('#listForm').submit(function(e){
            e.preventDefault();

            let name = $('#listname').val().trim();

            if (name.length === 0){
                M.toast({html: 'List name cannot be empty!', displayLength: 2000});
                return;
            }
            $.post("lists.php", {name : name, email : email}, function(result){
                if (result.valid){
                    getLists();
                }else{
                    M.toast({html: 'List already exists!', displayLength: 2000});
                }
            });

        });


            
        
        
        $('body').on('click', '.thing', function() {
            $('#itemBox').removeClass("hide");

            let listName = $(this).attr("id");

            rows = `<h3 class="center-align"> ${listName} </h3>`;
            $.get("items.php", {email : email, listName : listName}, function(data){
                rows = `<h3 class="center-align"> ${listName} </h3>`;
                for (let list of data){
                    rows += `
                    <div class="white item-card">
                        <div class="col s1">
                            <label>
                                <input class="slash ${list.item}" name="slash" type="checkbox"/>
                                <span></span>
                            </label>
                        </div>
                        <div class="col s9 ${list.item}">${list.item}</div>
                        <div class="col s1"> <a class= "${list.item} star" href="#"><i class="material-icons">star_border</i></a></div>
                        <div class="col s1"> <a class= "${list.item} delete" href="#"><i class="material-icons">delete</i></a></div>
                    </div>
                    `;
                }
                $('#mainbody').html(rows);
            });
        });
        

        $('#itemform').submit(function(e){
            e.preventDefault();

            let item = $('#itemEnter').val().trim();
            let listName = $('h3').text()

            if (item.length === 0){
                M.toast({html: 'Item cannot be empty!', displayLength: 2000});
                return;
            }
            
            $.post("items.php", {item : item, email : email, listName : listName}, function(result){
                if (result.valid){
                    aler("okay");
                }else{
                    M.toast({html: 'Item already exists!', displayLength: 2000});
                }
            });
            $('#itemEnter').val('');
        });
        



        $('body').on('click', '.slash', function() {
            var id = $(this).attr("class").split(' ')[1];
            var x = $("." + id);
            if (x.hasClass("slashed")){
                x.removeClass("slashed");
            }else{
                x.addClass("slashed");
            }
        });


        $('body').on('click', '.star', function() {
            if ($(this).text() == "star_border"){
                $(this).html(`<i class="material-icons">star</i>`);
                var f = $(this).attr("class").split(' ')[0];
                addToFav(f);
            }else{
                $(this).html(`<i class="material-icons">star_border</i>`);
            }
        });


        function addToFav(){
            $.post("impo.php", {name : name, state : "add"}, function(result){
                if (result.valid){
                    getImpo();
                }
            })
        }
        

        $('#impo').click(function(){
            $('#itemBox').addClass("hide");
            getImpo();
        });    

        function getImpo(){
            $.get("impo.php", {email : email}, function(data){
            rows = `<h3 class="center-align"> Important </h3>`;
            for (let list of data){
                rows += `
                <div class="white item-card">
                    <div class="col s1">
                        <label>
                            <input class="slash ${list.item}" name="slash" type="checkbox" />
                            <span></span>
                        </label>
                    </div>
                    <div class="col s9 ${list.item}">${list.item}</div>
                    <div class="col s1"><i class="material-icons">star</i></div>
                    <div class="col s1"><i class="material-icons">delete</i></div>
                </div>
                `;
            }
            $('#mainbody').html(rows);
        });

}

    })

  </script>
  </body>
</html>