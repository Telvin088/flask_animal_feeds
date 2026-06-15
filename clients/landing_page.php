<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include("db_connection.php");

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$profile_picture_path = "";

$select_query = "SELECT profile_picture FROM users WHERE id = ?";
$select_stmt = $pdo->prepare($select_query);
$select_stmt->execute([$user_id]);
$user_data = $select_stmt->fetch();

if ($user_data) {
    $profile_picture_path = $user_data["profile_picture"];
}

if (empty($profile_picture_path)) {
    $profile_picture_path = "default_profile_picture.jpg";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="landing_page.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="ism/js/ism-2.2.min.js"></script>
    <title>ANIMAL FEEDS LANDING</title>
</head>

<body>
    <div class="navigation-bar">
        <ul>
            <li>
                <a href="">
                    <img src="https://admin.pixelstrap.com/cion/assets/images/logo/logo.png" alt="">
                </a>
            </li>
            <li>
                <a href="">HOME</a>
            </li>
            <li>
                <a href="#about">ABOUT</a>
            </li>
            <li>
                <a href="#services">SERVICES</a>
            </li>
            <li>
                <a href="#portfolio">PORTFOLIO</a>
            </li>
            <li>
                <a href="#testimonials">TESTIMONIAL</a>
            </li>
            <li>
                <a href="#blog">BLOG</a>
            </li>
            <li>
                <a href="#contact">CONTACT</a>
            </li>
            <li>
                <p style="color: #fa9b1b;"><?php echo $username; ?></p>
            </li>
            <li>
                <img src="<?php echo $profile_picture_path; ?>" alt="">
            </li>
            <li>
                <a id="logout-button" href="#">
                    <span class="material-symbols-rounded">
                        arrow_drop_down
                    </span>
                </a>
            </li>
        </ul>
        <div class="logout-button">
            <a href="logout.php">
                <span class="material-symbols-rounded">
                    move_item
                </span>
                <span>Logout</span>
            </a>
        </div>
    </div>
    <div class="background-intro">
        <img src="https://foundationfar.org/wp-content/uploads/2020/07/Vet-caring-for-cow_web_desktop-1024x410.jpg" alt="">
    </div>
    <div class="background-intro-text">
        <h2>
            <span style="color: #bbb; font-size: 25px;">Cultivating dreams<br></span><span style="color: #bbb; font-family: 'Oswald', sans-serif;">Harvesting Success:<br>
            </span><span style="color: #bbb; font-family: 'Oswald', sans-serif;">Welcome to <span style="color: #bbb; font-family: 'Oswald', sans-serif; text-decoration: underline;">FEEDS KENYA</span></span>
        </h2>
        <p>Built on the foundation of knowledge, dedication, and a relentless pursuit of<br>excellence in agriculture. We take pride in supporting both small-scale and<br>large-scale agricultural operations</p>
        <button style="color: #ffffff; border: 3px solid #ffffff; font-weight: bold;">Contact US</button>
    </div>

    <section id="about">
        <div class="about-left">
            <img src="https://preetheme.com/html/asik/assets/img/me.png" alt="">
            <button>
                <span>Founder and Manager</span>
            </button>
        </div>
        <div class="about-right">
            <h4>About Us</h4>
            <h3>Mission, Vision and Core Values</h3>
            <p>Empower and uplift farmers by providing essential, high-quality animal feeds at no cost, ensuring the nourishment of livestock and fostering sustainable agriculture practices for communities facing economic challenges.
            </p>
            <p>To create a thriving agricultural landscape where every farmer, regardless of financial constraints, has access to nutritious animal feeds, resulting in healthier livestock, increased farm productivity, and improved overall well-being for rural communities.</p>
            <p>Quality Assurance: Uphold the highest standards in sourcing, manufacturing, and distribution</p>
            <div class="about-right-description">
                <div class="about-right-description-left">
                    <p class="description">Anniversary: <span>23</span></p>
                    <p class="description">Address: <span>6235, Kenya, Earth</span></p>
                    <p class="description">Email: <span>feedskenya@gmail.com</span></p>
                    <p class="description">Address: <span>6235, Kenya, Earth</span></p>
                </div>
                <div class="about-right-description-right">
                    <p class="description">Phone: <span>+254 717927780</span></p>
                    <p class="description">Website: <span>feedskenya.com</span></p>
                    <p class="description">Base: <span>Kenya</span></p>
                </div>
            </div>
            <!-- <button><a style="text-decoration: none; color: #ffffff;" href="#services">View Services</a></button> -->
            <div class="social-media-container">
                <i class="lab la-facebook-f"></i>
                <i class="lab la-twitter"></i>
                <i class="lab la-instagram"></i>
                <i class="lab la-linkedin-in"></i>
                <i class="lab la-github"></i>
                <i class="lab la-google-plus-g"></i>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="services-intro-text">
            <h3>Our Awesome Services</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero doloribus, recusandae sapiente
                maxime<br>repellendus, hic velit vel nisi iure porro.</p>
        </div>
        <div class="services-cards">
            <div class="services-card">
                <span class="material-symbols-rounded">
                    compost
                </span>
                <h3>Free Food Distribution</h3>
                <p style="padding: 10px;">Provide complimentary, high-quality animal feeds to farmers facing financial constraints for sustainable livestock nutrition.</p>
            </div>
            <div class="services-card"><span class="material-symbols-rounded">
                    bookmark_manager
                </span>
                <h3>Nutritional Consultations</h3>
                <p style="padding: 10px;">Offer expert advice on optimizing livestock diets for enhanced health, productivity, and overall well-being.</p>
            </div>
            <div class="services-card">
                <span class="material-symbols-rounded">
                    cut
                </span>
                <h3>Farm Sustainablity Workshops</h3>
                <p style="padding: 10px;">Conduct educational programs to empower farmers with knowledge on sustainable agriculture practices and resource management.</p>
            </div>
            <div class="services-card">
                <span class="material-symbols-rounded">
                    pets
                </span>
                <h3>Livestock Health Clinics</h3>
                <p style="padding: 10px;">Organize veterinary services to ensure the well-being of animals through regular health check-ups and vaccinations.</p>
            </div>
            <div class="services-card">
                <span class="material-symbols-rounded">
                    microbiology
                </span>
                <h3>Community Outreach Events</h3>
                <p style="padding: 10px;">Engage with local communities through awareness campaigns, fostering a sense of unity and collaboration in agriculture.</p>
            </div>
            <div class="services-card">
                <span class="material-symbols-rounded">
                    biotech
                </span>
                <h3>Training Programs for Farmers</h3>
                <p style="padding: 10px;">Equip farmers with essential skills and knowledge, enhancing their ability to manage and optimize livestock farming practices.</p>
            </div>
        </div>
    </section>

    <section id="portfolio">
        <div class="portfolio-header">
            <h3>Our Portfolio</h3>
            <p>The organization is dedicated to providing essential support to financially challenged farmers by offering complimentary, premium animal feeds for optimal livestock<br>nutrition and health. Additionally, the organization extends its commitment through expert-guided nutritional consultations, empowering farmers to<br>customize diets for enhanced productivity and overall well-being.</p>
        </div>
        <div class="portfolio-links">
            <button href="all">All</button>
            <button href="">Animals</button>
            <button href="">Web</button>
            <button href="">Card</button>
        </div>
        <div class="portfolio-cards">
            <div class="portfolio-card">
                <img src="https://lh3.googleusercontent.com/Bbt-Ed64evkC64i2p8pWee905Lvoa0vxgKhLj_qbyarW1v7PRGJTQ3medhCU4Fil5Ek7eHKXpamLukP9faCau5rfa4Lm1XCyyzOpl3Le=s750" alt="">
            </div>
            <div class="portfolio-card">
                <img src="https://www.shutterstock.com/image-photo/farmer-handfeeds-his-hens-grain-600nw-1814333030.jpg" alt="">
            </div>
            <div class="portfolio-card">
                <img src="https://www.kenyanews.go.ke/wp-content/uploads/2022/03/DSC_0253-1200x630.jpg" alt="">
            </div>
            <div class="portfolio-card">
                <img src="https://www.kbc.co.ke/wp-content/uploads/2023/10/Photo-1.png" alt="">
            </div>
            <div class="portfolio-card">
                <img src="https://glw-feeds.co.uk/wp-content/uploads/2023/10/GLW-14-1-1024x500.jpg" alt="">
            </div>
            <div class="portfolio-card">
                <img src="https://www.kirdi.go.ke/sites/default/files/2022-09/Animal%20Feeds%20Formulation%20Training%20Participants.JPG" alt="">
            </div>
        </div>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "agrikenya_clients";

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the very last 'id' from the 'users' table
        $sql = "SELECT id FROM users ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastId = $row["id"];
            // echo "The last ID is: " . $lastId;
        }
        ?>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "agrikenya_clients";

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the very last 'id' from the 'users' table
        $sql = "SELECT request_id FROM recent_requests ORDER BY request_id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $finalId = $row["request_id"];
            // echo "The last ID is: " . $lastId;
        }
        ?>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "agrikenya_admin";

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve the very last 'id' from the 'users' table
        $sql = "SELECT event_id FROM new_events ORDER BY event_id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $eventId = $row["event_id"];
            // echo "The last ID is: " . $lastId;
        }
        ?>
        <div class="summary">
            <div class="summary-card">
                <span class="material-symbols-rounded">
                    assignment
                </span>
                <h2><?php echo $finalId; ?></h2>
                <p>Projects</p>
            </div>
            <div class="summary-card">
                <span class="material-symbols-rounded">
                    star
                </span>
                <h2><?php echo $eventId; ?></h2>
                <p>Hosted Events</p>
            </div>
            <div class="summary-card">
                <span class="material-symbols-rounded">
                    person
                </span>
                <h2><?php echo $lastId; ?></h2>
                <p>Clients</p>
            </div>
            <!-- <div class="summary-card">
                <span class="material-symbols-rounded">
                    tactic
                </span>
                <h2>12</h2>
                <p>Active Projects</p>
            </div> -->
        </div>
    </section>

    <section id="testimonials">
        <div class="testimonials-header">
            <h3>Our Testimonials</h3>
            <p>Discover the stories of those who've reaped the benefits of<br>Feeds Kenya commitment to agricultural excellence..</p>
        </div>
        <div class="testimonial-card">
            <img src="https://img.freepik.com/free-photo/portrait-hesitant-man-purses-lips-looks-bewilderment-feels-doubt_273609-16785.jpg" alt="">
            <h2>Telvin Maina</h2>
            <p>Pig Farmer</p>
            <div class="testimonial-stars">
                <i class="las la-star"></i>
                <i class="las la-star"></i>
                <i class="las la-star"></i>
                <i class="las la-star"></i>
                <i class="las la-star"></i>
            </div>
            <p>"Feeds Kenya transformed my farm. Their quality seeds and<br>advice led to bountiful harvests. Forever grateful!"</p>
        </div>
    </section>
    <section id="featured-products">
        <div class="featured-top">
            <h2>Top Requested Products</h2>
            <p>Explore the agricultural marvel that farmers can't get enough<br>of - our highly sought-after, top-requested product..</p>
        </div>
        <?php include 'fetch_topordered.php'; ?>
    </section>
    <!-- <section id="requests">
        <div class="requests-header">
            <h2>Request Product</h2>
            <p>Take the reins of your agricultural needs with our product request form.<br>It's your direct line to the farming solutions you desire.</p>
        </div>
        <div class="requests-body">
            <div class="requests-left">
                <h2>Looking for a Free Giveaway?</h2>
                <p>Fill out the form. You will receive an email or phone call confirming<br>whether you are eligible for the 'in-house sponsorship'</p>
                <p style="margin-right: 60px;">Complete the form effortlessly. Step 1: Enter your name. Step 2: Provide your<br>phone number. Step 3: Share your email. Step 4: Specify your location. Step 5:<br>Request your desired product.</p>
            </div>
            <div class="requests-right">
                <form action="save_requests.php" method="post">
                    <input type="text" id="name" name="name" placeholder="Name" required>

                    <input type="tel" id="phone" name="phone" placeholder="Phone" required><br>

                    <input type="email" id="email" name="email" placeholder="Email" required><br>

                    <input type="text" id="location" name="location" placeholder="Location" required>

                    <label for="product">Product:</label>
                    <select id="product" name="product">
                        <option value="coffee_seeds">Coffee Seeds</option>
                        <option value="kale_seeds">Kale Seeds</option>
                        <option value="jerrycans">Jerry Cans</option>
                    </select><br>

                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </section> -->
    <section  id="featured-products">
        <div class="featured-top">
            <h2>Featured Products</h2>
            <p>Discover Excellence in Animal Farming: Our Top Featured Products. Explore a curated selection<br>of our finest products that redefine farming success.</p>
            <div style='display: flex; width: 140px; justify-content: space-between;'>
                <button style="background-color: #fa9b1b; border: 1px solid black; border-radius: 10px;" id='availableButtonn'>Available</button>
                <button id='notAvailableButtonn'>Request</button>
            </div>
        </div>
        <div style="display: block;" id="availableSectionn">
            <?php include 'fetch_featured.php'; ?>
        </div>
        <div style="display: none; border: 1px solid red; height: 300px; width: 90%; margin-left: 5%;" id="notAvailableSectionn">
            <form data-aos="zoom-in-up" style="z-index: 1; margin-left: 500px; margin-top: 100px; position: relative; border: 1px solid #ffffff; font-family: Oswald, sans-serif; box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); -webkit-box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); height: 240px; width: 400px; background-color: #ffffff; border-radius: 5px;" action="save_missing.php" method="post">
                <h4 style="margin-left: 18px; margin-top: 10px; color: green; display: flex; align-items: center;"><span class="material-symbols-rounded">verified</span><span>Request Product</span></h4>
                <input style="height: 25px; margin-left: 18px; width: 169px; margin-top: -20px; font-family: Oswald, sans-serif;" type="text" id="name" name="name" placeholder="Name" required>

                <input style="height: 25px; width: 169px; margin-top: -20px; font-family: Oswald, sans-serif;" type="text" id="phone" name="phone" placeholder="Phone" required><br>

                <input style="width: 170px; margin-left: 18px; height: 25px; margin-top: 10px; font-family: Oswald, sans-serif;" type="email" id="email" name="email" placeholder="Email" required>

                <input style="width: 166px; margin-left: 0px; height: 25px; margin-top: 10px; font-family: Oswald, sans-serif;" type="quantity" id="quantity" name="quantity" placeholder="quantity" required>

                <input style="height: 25px; margin-left: 18px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="text" id="location" name="location" placeholder="Location" required>

                <input style="height: 25px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="text" id="product" name="product" placeholder="Product" required><br>

                <input style="height: 25px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="hidden" id="status" name="status" placeholder="status" required><br>

                <input style="font-family: Oswald, sans-serif; background-color: #fa9b1b; border: none; color: #ffffff; border-radius: 3px; width: 90px; margin-left: 18px; margin-top: 10px;" type="submit" value="Submit">
            </form>
        </div>
    </section>
    <section id="blog">
        <div class="blog-header">
            <h2>Our Latest Blog</h2>
            <p>Welcome to our animal feeds blog, where we cultivate knowledge, share insights, and nurture<br>your understanding of farming, sustainability, and innovation.</p>
        </div>
        <div class="blog-cards">
            <?php include 'fetch_events.php'; ?>
            <!-- <div class="blog-card">
                <img src="https://preetheme.com/html/asik/assets/img/blog/item1.jpg" alt="">
                <span class="align-icons">
                    <span class="material-symbols-rounded">
                        person
                    </span>
                    <span>Admin</span>
                    <span class="material-symbols-rounded">
                        message
                    </span>
                    <span>3 comments</span>
                </span>

                <h3>Data Science and Software</h3>
                <p>Contrary to popular belief, Lorem Ipsum is not<br>simply random text. It has roots in a piece
                    of<br>classical Latin literature from 45 BC, making it<br>over 2000 years old.</p>
            </div>
            <div class="blog-card">
                <img src="https://preetheme.com/html/asik/assets/img/blog/item2.jpg" alt="">
                <span class="align-icons">
                    <span class="material-symbols-rounded">
                        person
                    </span>
                    <span>Admin</span>
                    <span class="material-symbols-rounded">
                        message
                    </span>
                    <span>3 comments</span>
                </span>

                <h3>Data Science and Software</h3>
                <p>Contrary to popular belief, Lorem Ipsum is not<br>simply random text. It has roots in a piece
                    of<br>classical Latin literature from 45 BC, making it<br>over 2000 years old.</p>
            </div>
            <div class="blog-card">
                <img src="https://preetheme.com/html/asik/assets/img/blog/item3.jpg" alt="">
                <span class="align-icons">
                    <span class="material-symbols-rounded">
                        person
                    </span>
                    <span>Admin</span>
                    <span class="material-symbols-rounded">
                        message
                    </span>
                    <span>3 comments</span>
                </span>

                <h3>Data Science and Software</h3>
                <p>Contrary to popular belief, Lorem Ipsum is not<br>simply random text. It has roots in a piece
                    of<br>classical Latin literature from 45 BC, making it<br>over 2000 years old.</p>
            </div> -->
        </div>
    </section>
    <section id="contact">
        <div class="contact-header">
            <h3>Contact Me</h3>
            <p>Let's Connect! Your questions, feedback, and inquiries matter. Reach out via<br>our contact form, and we'll be delighted to assist you.</p>
        </div>
        <div class="contact-body">
            <div class="contact-form">
                <h3>Contact Me</h3>
                <form action="save_messages.php" method="post">
                    <input type="text" name="name" placeholder="Name">
                    <input type="text" name="email" placeholder="Email"><br>
                    <input type="text" name="subject" id="subject" placeholder="Subject"><br>
                    <textarea name="message" id="" cols="102" rows="8" placeholder="Message"></textarea><br>
                    <button>Send Message</button>
                </form>
            </div>
            <div class="contact-details">
                <h3>Our Contact Details</h3>
                <p>Get in touch effortlessly. Our 'Contact Us' form is your bridge to effective communication. Share your inquiries, feedback, or questions with us..</p>
                <p>Connect with us easily through our 'Contact Us' form. We're here to listen, assist, and engage in fruitful conversations. Your feedback matters</p>
                <span>
                    <span class="material-symbols-rounded">
                        location_on
                    </span>
                    <span>
                        <h3>Address: <span style="font-weight: lighter;">112 Strina, lite House</span></h3>
                    </span>
                </span>
                <span>
                    <span class="material-symbols-rounded">
                        call
                    </span>
                    <span>
                        <h3>Phone: <span style="font-weight: lighter;">+254 710226244</span></h3>
                    </span>
                </span>
                <span>
                    <span class="material-symbols-rounded">
                        mail
                    </span>
                    <span>
                        <h3>Email: <span style="font-weight: lighter;">charity@gmail.com</span></h3>
                    </span>
                </span>
            </div>
        </div>
    </section>


    <script src="landing_page.js"></script>
    <script>
        const availableBtn = document.getElementById('availableButtonn');
        const availableSection = document.getElementById('availableSectionn');
        const notAvailableBtn = document.getElementById('notAvailableButtonn');
        const notAvailableSection = document.getElementById('notAvailableSectionn');

        availableBtn.addEventListener('click', () => {
            availableSection.style.cssText = 'display: block;';
            availableBtn.style.cssText = 'background-color: #fa9b1b; border: 1px solid black; border-radius: 10px;';
            notAvailableBtn.style.cssText = 'border: 1px solid grey';
            notAvailableSection.style.cssText = 'display: none;';
        })

        notAvailableBtn.addEventListener('click', () => {
            notAvailableSection.style.cssText = 'display: block;';
            notAvailableBtn.style.cssText = 'background-color: #fa9b1b; border: 1px solid black; border-radius: 10px;';
            availableBtn.style.cssText = 'border: 1px solid grey';
            availableSection.style.cssText = 'display: none;';
        })
    </script>
    <script>
        const accountEl = document.getElementById("logout-button");
        const profileEl = document.querySelector(".logout-button");

        function openProfile() {
            profileEl.style.display = "block";
            setTimeout(() => {
                profileEl.style.opacity = "1";
            }, 10);
        }

        function closeProfile() {
            profileEl.style.opacity = "0";
            setTimeout(() => {
                profileEl.style.display = "none";
            }, 300);
        }

        accountEl.addEventListener("click", (e) => {
            e.stopPropagation();
            if (profileEl.style.display === "block") {
                closeProfile();
            } else {
                openProfile();
            }
        });

        window.addEventListener("click", (e) => {
            if (e.target !== accountEl && !profileEl.contains(e.target)) {
                closeProfile();
            }
        });

        profileEl.addEventListener("click", (e) => {
            e.stopPropagation();
        });
    </script>

    <!-- Include jQuery library for AJAX -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Create an iframe to load the external HTML file -->
    <iframe style="display: none;" id="externalFrame" src="fetch_featured.php"></iframe>

    <script src="jquery.min.js"></script> <!-- Add your jQuery library -->

    <script>
        let formPopUp;

        $(document).on('click', '.showPopupButton', function() {
            const productId = $(this).data('product-id');

            $.ajax({
                url: 'fetch_amount.php?id=' + productId,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    const amountFromDatabase = parseInt(data); // Parse the response as an integer

                    if (amountFromDatabase > 0) {
                        // If the amount is greater than zero, show the pop-up form
                        formPopUp = document.createElement('div');
                        formPopUp.innerHTML = `
            <form data-aos="zoom-in-up" style="z-index: 1; position: relative; border: 1px solid #ffffff; font-family: Oswald, sans-serif; box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); -webkit-box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); margin-top: -2070px; margin-left: 20px; height: 240px; width: 400px; background-color: #ffffff; border-radius: 5px;"  action="save_requests.php" method="post">
            <h4 style="margin-left: 18px; margin-top: 10px; display: flex; align-items: center;"><span style="color: green;" class="material-symbols-rounded">verified</span><span style="color: green;">Available</span></h4>
                <input style="height: 25px; margin-left: 18px; width: 169px; margin-top: -20px; font-family: Oswald, sans-serif;" type="text" id="name" name="name" placeholder="Name" required>

                <input style="height: 25px; width: 169px; margin-top: -20px; font-family: Oswald, sans-serif;" type="text" id="phone" name="phone" placeholder="Phone" required><br>

                <input style="width: 170px; margin-left: 18px; height: 25px; margin-top: 10px; font-family: Oswald, sans-serif;" type="email" id="email" name="email" placeholder="Email" required>
                <input style="width: 166px; margin-left: 0px; height: 25px; margin-top: 10px; font-family: Oswald, sans-serif;" type="quantity" id="quantity" name="quantity" placeholder="quantity" required>

                <input style="height: 25px; margin-left: 18px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="text" id="location" name="location" placeholder="Location" required>

                <input style="height: 25px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="text" id="product" name="product" placeholder="Product" required><br>

                <input style="height: 25px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="hidden" id="status" name="status" placeholder="status" required><br>

                <input style="font-family: Oswald, sans-serif; background-color: #fa9b1b; border: none; color: #ffffff; border-radius: 3px; width: 90px; margin-left: 18px; margin-top: 10px;" type="submit" value="Submit">
            </form>
        `;
                        document.body.appendChild(formPopUp);
                        // Prevent click propagation within the form
                        formPopUp.addEventListener('click', function(event) {
                            event.stopPropagation();
                        });
                    } else {
                        // If the amount is not available (less than or equal to zero), show the form
                        formPopUp = document.createElement('div');
                        formPopUp.innerHTML = `
            <form data-aos="zoom-in-up" style="z-index: 1; margin-top: -300px; position: relative; border: 1px solid #ffffff; font-family: Oswald, sans-serif; box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); -webkit-box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: -1px 3px 5px 0px rgba(0,0,0,0.75); margin-top: -2070px; margin-left: 20px; height: 240px; width: 400px; background-color: #ffffff; border-radius: 5px;" action="save_missing.php" method="post">
            <h4 style="margin-left: 18px; margin-top: 10px; color: red; display: flex; align-items: center;"><span class="material-symbols-rounded">warning</span><span>Not Available => Request</span></h4>
                <input style="height: 25px; margin-left: 18px; width: 169px; margin-top: -20px; font-family: Oswald, sans-serif;" type="text" id="name" name="name" placeholder="Name" required>

                <input style="height: 25px; width: 169px; margin-top: -20px; font-family: Oswald, sans-serif;" type="text" id="phone" name="phone" placeholder="Phone" required><br>

                <input style="width: 170px; margin-left: 18px; height: 25px; margin-top: 10px; font-family: Oswald, sans-serif;" type="email" id="email" name="email" placeholder="Email" required>

                <input style="width: 166px; margin-left: 0px; height: 25px; margin-top: 10px; font-family: Oswald, sans-serif;" type="quantity" id="quantity" name="quantity" placeholder="quantity" required>

                <input style="height: 25px; margin-left: 18px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="text" id="location" name="location" placeholder="Location" required>

                <input style="height: 25px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="text" id="product" name="product" placeholder="Product" required><br>

                <input style="height: 25px; width: 169px; margin-top: 10px; font-family: Oswald, sans-serif;" type="hidden" id="status" name="status" placeholder="status" required><br>

                <input style="font-family: Oswald, sans-serif; background-color: #fa9b1b; border: none; color: #ffffff; border-radius: 3px; width: 90px; margin-left: 18px; margin-top: 10px;" type="submit" value="Submit">
            </form>
        `;
                        document.body.appendChild(formPopUp);

                        // Prevent click propagation within the form
                        formPopUp.addEventListener('click', function(event) {
                            event.stopPropagation();
                        });
                    }
                }
            });

            // Attach a click event handler to the document to close the popup when clicking outside
            $(document).on('click', function() {
                if (formPopUp) {
                    document.body.removeChild(formPopUp);
                    formPopUp = null; // Clear the reference to the popup
                }
            });
        });
    </script>

</body>

</html>