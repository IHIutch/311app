<?php include "inc/header.php";?>


<div class="container">
    <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 mt-5">
            <div class="mb-5">
                <h2><b>What is the point of all this?</b></h2>
                <p class="mb-5">311 services play an incredible role in our cities today as an effective way of communicating needs of citizens directly to government. They give cities an immediate look into where improvements can be made and in some instances, predict what their needs will be.</p>

                <div class="border rounded p-3">
                    <h5><b>TL/DR:</b></h5>
                    <ul class="mb-0">
                        <li>Improved usability leads to increased use.</li>
                        <li>More data leads to better decision making.</li>
                        <li>More transparency means feeling more connected to your community.</li>
                        <li>311 has to keep up with technology to stay effective.</li>
                        <li>Buffalo could lead the country by enlisting the help of its citizens.</li>
                    </ul>
                </div>
            </div>

            <div class="mb-5">
                <h4><b>I believe we can do better</b></h4>
                <p>311 systems today are invaluable, that is clear, but what if they were as easy and as well designed as other modern apps we use today, like Facebook, Amazon, or Google? These companies understand that the lifeblood of their service is usability. Making it as easy as possible to connect, buy, search is what makes these companies so powerful. Why can’t 311 work the same way? Buffalo’s 311 system currently takes in around 200 reports daily. Imagine how many more reports would be generated if it were easier to create a report. More issues could be resolved, the city could have a better sense of citizens needs, and money could be allocated more appropriately.</p>
            </div>

            <div class="mb-5">
                <h4><b>Its all about the data</b></h4>
                <p>The data is what makes this all work. A report comes in, it's assigned to a department, and eventually it gets resolved (some in 48 hours!). What happens when we have more data? What if we could share that data live? More data and greater access gives cities and citizens a chance to connect with the data and make tools that continue to improve our communities. In Boston, students designed an app that <a href="https://www.wired.com/insights/2014/03/potholes-big-data-crowdsourcing-way-better-government/">automatically reports potholes to the city</a>. Washington DC was able to use machine learning to start to <a href="https://www.citylab.com/solutions/2017/08/smart-cities-fight-rat-infestations-big-data/535407/">predict where rat infestations might pop u</a>p. The more data we can collect the better we will be at allocating resources appropriately, better understanding citizens needs, and even creating predictive models about where and when the next problems will come up.</p>
            </div>

            <div class="mb-5">
                <h4><b>A need for transparency</b></h4>
                <p>Not only does the data need collected, it also needs to be shared. With the technology we have today, there is no reason we shouldn’t be able to have a live look at the issues and needs that citizens are having. This creates an environment of connectivity, transparency, and accountability; things we should always demand of our government. Why shouldn’t our government systems have customer service experiences that we demand from any company. What happens when you buy something on Amazon? You get a receipt, you have a tracking number, if you have an issue you can call and talk to someone right away and they’ll find a way to fix it. You feel connected and invested in the entire process. The more we feel connected to our communities and that our needs are being met, the stronger our communities will be. Additionally, improved transparency gives us the ability to hold our government accountable. Do you feel like one issue is more important than another? Now you have the data to show for it. Do you think it's taking too long for an issue to be resolved? Now you have the data to show for it. Government is for the people, by the people, of the people, so its only right that we should have a window looking in to make sure it's all going the way we think it should.</p>
            </div>

            <div class="mb-5">
                <h4><b>Scalability and iterative design</b></h4>
                <p>Like any good digital tool, 311 should stay lean and get smarter. How can we solve the biggest issues more efficiently? How can we test new ideas and constantly make small improvements along the way? The digital space is the perfect place for trial and error. The risks can be low and the rewards can be great, so we should always be learning. Our cities should be getting faster, smarter, and more effective at responding to citizens needs. But they’ll only do that if we’re willing to put our 311 systems to the test.</p>
            </div>

            <div class="mb-5 pb-4 border-bottom">
                <p>With the proper design and guidance in place, 311 systems can be on the forefront of changing the ways cities behave in the 21st century. And I want Buffalo to lead this charge. But the technology has to keep up with the times, otherwise its just another pain-in-ass government program that was built 20 years ago. I think the digital space is the perfect place for concerned citizens with the proper know how to contribute to their communities. I created this tool to show how simple it is for one person to contribute. Its not perfect by any means, but its a step in the right direction and I think its the way cities will get stronger in the future.</p>
            </div>
            <div class="mb-5">
                <p>If you made it this far, please consider leaving some <a href="feedback.php">feedback</a>. If you think this could be a powerful tool, share with your friends or with your local government official. I'd love to see this app go further and shaped by the community. </p>
            </div>
            <div class="text-center">
               <div class="text-uppercase small mb-2"><b>Share</b></div>
                <div class="btn btn-secondary d-inline-block" id="fbShare"><i class="fab fa-facebook"></i></div>
                <div class="btn btn-secondary d-inline-block" id="twShare"><i class="fab fa-twitter"></i></div>
                <div class="btn btn-secondary d-inline-block" onClick="copyLink()" id="copyLink"><i class="fas fa-link"></i></div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#fbShare').click( function(){
        window.open('https://www.facebook.com/sharer/sharer.php?u=beta.buffalo311.org&t='+document.title, '', 
        'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=436,width=646');
        return false;
    });
    $('#twShare').click( function(){
        var shareText = 'Check out'
        window.open('https://twitter.com/share?text='+shareText+'&amp;url=https://beta.buffalo311.org', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=436,width=646'); 
        return false;
    });
    
    $('#copyLink').tooltip({
        title: 'Link copied!',
        animated: 'fade',
        placement: 'top',
        trigger: 'click',
        delay: {hide: 100}
    });
    
    function copyLink(){
        var dummy = document.createElement('input'),
        text = window.location.href;
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
    }

</script>

<?php include "inc/footer.php";?>
