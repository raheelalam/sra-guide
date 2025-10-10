(function () {
    yugabyteLoadJs('/wp-content/themes/yugabyte/assets/js/jquery-3.6.1.min.js', 'BODY', 'jquery', function () {

        let resizeTimeout;

        function adjustVidTitles() {
            // Reset min-heights first
            $(".vid-title").css("min-height", "");

            let windowWidth = $(window).width();

            if (windowWidth > 767 && windowWidth < 992) {
                // Compare every 2 items
                $(".vid-item").each(function (index) {
                    if (index % 2 === 0) {
                        let $current = $(this).find(".vid-title");
                        let $next = $(this).next(".vid-item").find(".vid-title");

                        if ($next.length) {
                            let maxHeight = Math.max($current.outerHeight(), $next.outerHeight());
                            $current.css("min-height", maxHeight);
                            $next.css("min-height", maxHeight);
                        }
                    }
                });
            } else if (windowWidth > 991) {
                // Compare every 3 items
                $(".vid-item").each(function (index) {
                    if (index % 3 === 0) {
                        let $current = $(this).find(".vid-title");
                        let $next1 = $(this).next(".vid-item").find(".vid-title");
                        let $next2 = $(this).next(".vid-item").next(".vid-item").find(".vid-title");

                        if ($next1.length && $next2.length) {
                            let maxHeight = Math.max(
                                $current.outerHeight(),
                                $next1.outerHeight(),
                                $next2.outerHeight()
                            );
                            $current.css("min-height", maxHeight);
                            $next1.css("min-height", maxHeight);
                            $next2.css("min-height", maxHeight);
                        }
                    }
                });
            }
        }

        // Adjust titles on load
        adjustVidTitles();

        // Re-adjust titles on window resize with a debounce of 200ms
        $(window).resize(function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function () {
                adjustVidTitles();
            }, 200);
        });

    });
}());
