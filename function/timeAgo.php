<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

function timeAgo($time_ago)
                {
                    $time_ago = strtotime($time_ago);
                    $cur_time   = time();
                    $time_elapsed   = $cur_time - $time_ago;
                    $seconds    = $time_elapsed;
                    $minutes    = round($time_elapsed / 60);
                    $hours      = round($time_elapsed / 3600);
                    $days       = round($time_elapsed / 86400);
                    $weeks      = round($time_elapsed / 604800);
                    $months     = round($time_elapsed / 2600640);
                    $years      = round($time_elapsed / 31207680);
                    // Seconds
                    if ($seconds < 60) {
                        return "Just now";
                    }
                    //Minutes
                    else if ($minutes <= 60) {
                        if ($minutes == 1) {
                            return "1 minute ago";
                        } else {
                            return "$minutes minutes ago";
                        }
                    }
                    //Hours
                    else if ($hours <= 24) {
                        if ($hours == 1) {
                            return "1 hour ago";
                        } else {
                            return "$hours hours ago";
                        }
                    }
                    //Days
                    else if ($days <= 7) {
                        if ($days == 1) {
                            return "Yesterday";
                        } else {
                            return "$days days ago";
                        }
                    }
                    //Weeks
                    else if ($weeks <= 4.3) {
                        if ($weeks == 1) {
                            return "1 week ago";
                        } else {
                            return date('M j', $time_ago);
                        }
                    }
                    //Months
                    else if ($months <= 12) {
                        if ($months == 1) {
                            return date('M j', $time_ago);
                        } else {
                            return date('M j', $time_ago);
                        }
                    }
                    //Years
                    else {
                        if ($years == 1) {
                            return strtoupper(date('M j Y', $time_ago));
                        } else {
                            return strtoupper(date('M j Y', $time_ago));
                        }
                    }
                }
