        // Enhanced togglePopup function with animations
        function togglePopup() {
            const popup = document.getElementById("popupBox");
            popup.classList.toggle("active");
            
            // Prevent scrolling when popup is open
            document.body.style.overflow = popup.classList.contains("active") ? "hidden" : "";
        }

        // Close popup when clicking outside
        document.getElementById("popupBox").addEventListener("click", function(e) {
            if (e.target === this) {
                togglePopup();
            }
        });

        // Add animation delays for elements
        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll('.slide-in, .fade-in');
            
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.2}s`;
            });
            
            // Add loading animation
            document.body.style.opacity = 0;
            setTimeout(() => {
                document.body.style.transition = "opacity 0.5s ease";
                document.body.style.opacity = 1;
            }, 100);
        });
   