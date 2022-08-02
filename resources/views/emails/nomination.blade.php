<!DOCTYPE html>
<html>
    <head>
        <title>Kilimo Awards</title>
        
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
            .container{
                max-width: 600px;
                margin: auto;
            }
            .header{
                max-width: 600px;
                margin: auto;
                text-align: center;
            }
            .nomi{
                max-width: 600px;
                margin: auto;
                background-color: #006837;
            }
            .conn{
                max-width: 600px;
                background-color: #004425;
                padding: 5px;
                text-align: center;
                color: #ffffff;
                font-family: 'Montserrat', sans-serif;
                font-size: 0.7em;
            }
            .aza{
                max-width: 600px;
                display: flex;
                padding: 10px;
                padding-bottom: 30px;
                background-color: #006837;
                color: #ffffff;
                font-family: 'Montserrat', sans-serif;
                font-size: 0.8em;
            }
            .conrats{
                max-width: 250px;
                padding-left: 30px;
                
                
            }
            .abut{
                max-width: 250px;
                padding-left: 30px;                
            }
            a{
                text-decoration: none;
                color: #ffffff;
                font-weight: 700;
            }
            .promo{
                max-width: 600px;
            }
            .footer{
                max-width: 600px;
                padding: 30px;
                background-color: #1b1b1b;
                color: #ffffff;
                text-align: center;
                font-family: 'Montserrat', sans-serif;
                font-size: 0.7em;
            }
            
        </style>
    </head>
    <body>
        <div class="container">
        <div class="header">
            <img width="120" src="https://kilimomarathon.co.tz/imgs/KILIMO-MARATHON--EXPO-LOGO.png">
        </div>
        <div class="conn">
                <p><a href="https://kilimomarathon.co.tz">Home | </a><a href="https://kilimomarathon.co.tz/awards">Categories | </a><a href="https://kilimomarathon.co.tz/sponsorship">Sponsorship | </a><a href="https://kilimomarathon.co.tz/contact-us">Contact Us</a></p>
            </ul>
        </div>
        <div class="nomi">
            <img src="https://kilimomarathon.co.tz/images/banner.jpg">
        </div>
        <div class="aza">
            <div class="conrats">
                <h3>Congratulations</h3>
                <h2>{{ strtoupper($data['nominee_name']) }}</h2>
                <p>You have been officially NOMINATED <br> For the KILIMO Awards in the Category of</p>
                <h3>{{ strtoupper($data['award_name']) }}</h3>
            </div>

            <div class="abut">
                <h3>About The Awards</h3>
                <p>The KILIMO Awards are by far the biggest and most prestigious awards in Tanzania farming. Every year we review our award categories to ensure they better reflect the range of achievements that deserve recognition in the rapidly-changing world of agriculture.</p>

                <a href="{{ route('votes_nominees',$data['award_slug']) }}">View Nomination | </a>
                <a href="{{ route('votes_nominees',$data['award_slug']) }}"> Vote Now</a>
            </div>
        </div>
        <div class="promo">
            <img src="https://kilimomarathon.co.tz/images/promo.jpg">
        </div>
        <div class="footer">
            <div class="linki">
                <h2>#AnziaShambani</h2>
                <h4><a href="https://kilimomarathon.co.tz/">www.kilimomarathon.co.tz</a></h4>
                <p>429 Mahando Road, Masaki Dar es salaam<br>+255 754 222 800 | +255 624 222 211</p>
            </div>
            <div class="infoh">
                <p>You are receiving this email because you subscribed to our Mailshots. If you wish to stop receiving these emails the click <a href="#">Unsubscribe</a></p>
            </div>
        </div>
    </div>
    </body>
</html>