head     1.1;
branch   1.1.1;
access   ;
symbols  v10:1.1.1.1 apnscp:1.1.1;
locks    ; strict;
comment  @# @;


1.1
date     2004.12.13.00.03.55;  author root;  state Exp;
branches 1.1.1.1;
next     ;

1.1.1.1
date     2004.12.13.00.03.55;  author root;  state Exp;
branches ;
next     ;


desc
@@



1.1
log
@Initial revision
@
text
@#!/bin/sh
# Synopsis:
#    handles socket requests from WEBppliance, customized
#    circumvents the 'nobody' level of the Apache service
#    which Ensim runs.
#                   Author: Matt Saladna/msaladna@@apisnetworks.com
# $Id: localServer.tcl,v 1.52 2003/03/28 17:50:05 msaladna Exp $ */
# \
exec tclsh "$0" ${1+"$@@"}

# Changelog:
#     1.55 (03.26.03)-
#        all errors should now no longer block and return -1 to the sock
#        major internal fixes to system of handling commands
#        dynamicCustom introduced
#        added extraSecurity option parameter, scans the file for
#            cookie integrity
#     1.52 (03.16.03)-
#        cache of disk quota
#        configuration options added
#        fixed bug with spam entries
#        custom.tcl inclusion added
#     1.5 (02.06.03)-
#        first internal release

# error handling proc
# load up the Tcl PostgreSQL interface
load /usr/lib/libpgtcl.so

proc ::time {} {
	if {![info exists ::debug]} {
		set ::debug [clock seconds]
	}
}
proc ::bgerror {args} {
    if {$::LocalServer::debug} {
        puts [join "$args $::errorCode $::errorInfo"]
    }
    if {![info exists ::LocalServer::elogFile]} {
        set ::LocalServer::elogFile [open [file join $::LocalServer::logLocation localserver_error.log] {CREAT APPEND WRONLY}]
    }
    if {[string match "*apisnetworks*" $::errorInfo]} {
        set ::errorInfo ""
        set ::errorCode ""
    }
    puts $::LocalServer::elogFile "[clock format [clock seconds] -format "%c"]: [join $args]"
    close $::LocalServer::elogFile
    unset ::LocalServer::elogFile
    if {$::LocalServer::notifyErrors} {
        set fp [open "|$::LocalServer::sendmailPath" {WRONLY}]
        puts $fp "From: $::LocalServer::adminEmail\nTo: bugs@@apnscp.com\nSubject: Error in lService\n\n"
        puts $fp "[clock format [clock seconds] -format "%c"]: [join $args]"
        puts $fp ""
        close $fp
    }
}

# unknown call and standard
# configuration directive processing
proc ::unknown {args} {
    if {[string equal [lindex $args 1] "="]} {
        if {![string match "*;*" [lindex $args 0]]} {
            switch -- [string tolower [lindex $args 0]] {               
                "cache" {
                    set ::LocalServer::cacheLatency [lindex $args 2]
                }
                
                "debug" {
                    set ::LocalServer::debug [lindex $args 2]
                }
                
                "seed" {
                    set ::LocalServer::seed [lindex $args 2]
                }
                
                "port" {
                    set ::LocalServer::port [lindex $args 2]
                }
                
                "host" {
                    set ::LocalServer::host [lindex $args 2]
                }
                
                "loglocation" {
                    set ::LocalServer::logLocation [lindex $args 2]
                }
                
                "notifyerrors" {
                    set ::LocalServer::notifyErrors [lindex $args 2]
                }
                
                "adminemail" {
                    set ::LocalServer::adminEmail [lindex $args 2]
                }
                
                "extrasecurity" {
                    set ::LocalServer::extraSecurity [lindex $args 2]
                }
                
                "sendmailpath" {
                    set ::LocalServer::sendmailPath [lindex $args 2]
                }
                
                "extrasecurity" {
                    set ::LocalServer::extraSecurity [lindex $args 2]
                }
                
                "dynamiccustom" {
                    set ::LocalServer::dynamicCustom [lindex $args 2]
                }
            }
        }
    } else {
        error "Unknown command: [join $args]"
    }
}

namespace eval ::LocalServer {
    
    variable apnscp "1.0.4.2" ; # apnscp version: major, minor, super-minor
    variable isBeta 1 ; # beta?
    variable currentVersion "1.55"
    variable logFile
    variable elogFile
    variable cache ; # it's our domain cache
    variable cacheLatency ; # how many seconds will we cache our data...
    variable debug 0 ; # debugging facility
    variable seed ; # seed - not yet used
    variable logLocation
    variable host
    variable port 
    variable entry ; # IP field entries
    variable logLocation ; # location of log files
    variable seed ; # seed location
    variable notifyErrors ; # notify errors?
    variable adminEmail ; # e-mail of the main guy
    variable sendmailPath ; # path to sendmail
    variable fromPath ; # path to sendmail
    variable isValid ; # is the key valid
    variable lastCheck ; # last apnscp key check
    variable extraSecurity ; # 1/0 to check cookie names
    variable dynamicCustom ; # 1/0 to source the custom.tcl per socket conn
    variable connection ; # postgresql connection
}

# begin the server - not much to worry about here
proc ::LocalServer::InstantiateServer {} {
    ::LocalServer::MakeDBConnection
    #pg_on_connection_loss $::LocalServer::connection ::LocalServer::MakeDBConnection
    socket -myaddr $::LocalServer::host -server AcceptRequest $::LocalServer::port
    vwait forever
}

proc ::LocalServer::MakeDBConnection {} {
    if {[catch {set ::LocalServer::connection [pg_connect -conninfo "dbname=appldb"]} error]} {
        bgerror "Unable to connect to PostgreSQL database: $error"
        return -1
    }
    #pg_on_connection_loss $::LocalServer::connection \
        #[list bgerror "Connection Lost" ; ::LocalServer::MakeDBConnection]
}

# accept and read the request
proc ::LocalServer::AcceptRequest {sock addr port} {
    # let's check to see if this is originating from localhost
    # if it's not - return.
    if {![::LocalServer::CheckEntry $addr]} { ::bgerror "Unauthorized connection from $addr" ; catch {close $sock} ; return }
    fconfigure $sock -translation auto -blocking 0 ; # buffer by the line
    fileevent $sock readable [list ::LocalServer::ReadRequest $sock $addr $port]
}

proc ::LocalServer::GetServices {domain level} {
    set sitefp [open "/etc/virtualhosting/mappings/domainmap" "r"]
    catch {regexp -lineanchor "^$domain = (site\[0-9\]+)" [string trim [read $sitefp]] {} sitenum} error 
    close $sitefp
    #puts "Got Site"
    if {$level == "site"} {
        #puts "YAY"
        foreach i {files apache vhbackup sqmail analog majordomo frontpage mysql mivamerchant} {
            set fp [open "/home/virtual/$sitenum/info/current/$i" "r"]
            if {[string match "*enabled = 1*" [read $fp]]} {
                lappend lst "[set i]_enabled=1"
            } else {
                lappend lst "[set i]_enabled=0"
            }
            #puts "Done on $i"
            close $fp
        }
        # users (max users)
        set fp [open "/home/virtual/$sitenum/info/current/users" "r"]
        regexp {maxusers = ([0-9]+)} [read $fp] {} n
        lappend lst "users_maxusers=$n"
        close $fp
        #unset n
        unset fp
        # proftpd
        set fp [open "/home/virtual/$sitenum/info/current/proftpd" "r"]
                set txt [read $fp]
        if {[string match "*enabled = 1*" $txt]} {
            lappend lst "proftpd_enabled=1"
            #puts [read $fp]
            regexp {ftpserver = (.+)} $txt {} n
            lappend lst "proftpd_ftpserver=$n"
        } else {
            lappend lst "proftpd_enabled=0"
        }
        close $fp
        #unset n
        # sendmail

        set fp [open "/home/virtual/$sitenum/info/current/sendmail" "r"]
                set txt [read $fp]
        if {[string match "*enabled = 1*" $txt]} {
            lappend lst "sendmail_enabled=1"
            regexp {mailserver = ([^[:space:]]+)} $txt {} n
            lappend lst "sendmail_mailserver=$n"
        } else {
            lappend lst "sendmail_enabled=0"
        }
        close $fp
        #unset n
        # disk quota
        set fp [open "/home/virtual/$sitenum/info/current/diskquota" "r"]
                set txt [read $fp]
        if {[string match "*enabled = 1*" $txt]} {
            lappend lst "diskquota_enabled=1"
            regexp {quota = ([0-9\.]+)} $txt {} n
            lappend lst "diskquota_quota=$n"
        } else {
            lappend lst "diskquota_enabled=0"
        }
        close $fp
        
        # bandwidth
        set fp [open "/home/virtual/$sitenum/info/current/bandwidth" "r"]
        set txt [read $fp]
                if {[string match "*enabled = 1*" $txt]} {
            lappend lst "bandwidth_enabled=1"
            #puts [read $fp]
            regexp {threshold = ([0-9.]+)} $txt {} n
            lappend lst "bandwidth_threshold=$n"
        } else {
            lappend lst "bandwidth_enabled=0"
        }
        close $fp
        
        # ip info
        set fp [open "/home/virtual/$sitenum/info/current/ipinfo" "r"]
        set txt [read $fp]
                if {[string match "*namebased = 1*" $txt]} {
            lappend lst "ipinfo_namebased=1"
        } else {
            lappend lst "ipinfo_namebased=0"
        }
        regexp {\['(.+?)'\]} $txt {} n
        lappend lst "ipinfo_ipaddrs=$n"
        close $fp
        
    } elseif {$level == "user"} {
        foreach i {vhbackup sqmail} {
            set fp [open "/home/virtual/$sitenum/info/current/$i" "r"]
            set txt [read $fp]
            if {[string match "*enabled = 1*" $txt]} {
                lappend lst "[set i]_enabled=1"
            } else {
                lappend lst "[set i]_enabled=0"
            }
            close $fp
        }
        set fp [open "/home/virtual/$sitenum/info/current/sendmail" "r"]
        set txt [read $fp]
        if {[string match "*enabled = 1*" $txt]} {
            lappend lst "sendmail_enabled=1"
            regexp {mailserver = (.+)} $txt {} n
            lappend lst "sendmail_mailserver=$n"
        } else {
            lappend lst "sendmail_enabled=0"
        }
        close $fp
    } 
    #puts "Data returned: [join $lst |]"

    return [join $lst "|"]
}


proc ::LocalServer::CheckCache {host} {
    set bitFlag 0
    if {![info exists ::LocalServer::cache($host)]} { set bitFlag 1 }
    if {!$bitFlag && [expr {[clock seconds] - [lindex $::LocalServer::cache($host) 0] > $::LocalServer::cacheLatency}]} { set bitFlag 2 }
    if {$bitFlag} {
        # doesn't exist so let's populate this hash entry
        
        # get the total_bw
        # get the overage
        # get the threshold
        # get the begin date
        set res [pg_exec $::LocalServer::connection "select site_id, email from siteinfo where domain = '$host';"]
        set error [pg_result $res -error]
        if {![string equal "" $error]} {
            bgerror "Query Error: $error"
            puts $sock -1 ; catch {close $sock}
        } else {
            set tuple [pg_result $res -getTuple 0]
            # get the site id
            set siteid [lindex $tuple 0]
            # get the e-mail
            set email [lindex $tuple 1]
        }
        pg_result $res -clear
        
        set res [pg_exec $::LocalServer::connection "select begindate, rollover, threshold from bandwidth_spans CROSS JOIN bandwidth where bandwidth_spans.site_id = $siteid AND bandwidth_spans.enddate IS NULL AND bandwidth.site_id = $siteid;"]
        set error [pg_result $res -error]
        if {![string equal "" $error]} {
            bgerror "Query Error: $error"
            puts $sock -1 ; catch {close $sock}
        } else {
            # get the begin date
            set tuple [pg_result $res -getTuple 0]
            set begindate [lindex $tuple 0]
            # get the rollover
            set rollover [lindex $tuple 1]
            # get the threshold
            set threshold [lindex $tuple 2] 
        }
        pg_result $res -clear
        
        set res [pg_exec $::LocalServer::connection "select sum(in_bytes + out_bytes) from bandwidth_log where site_id = $siteid  AND ts >= '$begindate';"]
        set error [pg_result $res -error]
        if {![string equal "" $error]} {
            bgerror "Query Error: $error"
            puts $sock -1 ; catch {close $sock}
        } else {
            # get the begin date
            set bandwidth [pg_result $res -getTuple 0]
        }
        pg_result $res -clear
        
        # quota handling system
        set quota -1
        set quotafp [open "| /usr/bin/quota -g admin[set siteid]"]
        set quota [read $quotafp]
        catch {close $quotafp}
        if {[regexp {/[^[:space:]]+\s+([0-9]+)} [lindex [split $quota "\n"] 2] {} match]} {
            set quota $match
        }
        # structure:
        #    timestamp
        #    email
        #    total bw
        #    threshold
        #    begindate
        #    rollover date (can differ from begindate)
        #    quota
        set ::LocalServer::cache($host) [list [clock seconds] $email $bandwidth $threshold $begindate $rollover $quota $siteid]
        #puts $::LocalServer::cache($host)
        } 
}

proc ::LocalServer::ReadRequest {sock addr port} {
    if {[::LocalServer::CheckLicense] == 0} {
        set ::errorInfo ""
        set ::errorCode ""
        ::bgerror "Your apnscp copy is _NOT_ valid, please contact sales@@apnscp.com."
        puts $sock "ERROR: Invalid copy of apnscp, service killed."
        catch {close $sock}
        exit
    }
    set data [read $sock]
  
    if {![regexp {^\(([[:graph:]]+?) ([[:graph:]]+?)\) (.+)$} $data {} lockUser lockCookie data]} {
        ::bgerror "Malformed socket request!\n$data"
        puts $sock "-1"
        catch {close $sock}
        return
    }
    
    # extra security checks - check the local cookie
  
    if {$::LocalServer::extraSecurity} {
       if {[file exists [file join /usr apnscp var lock $lockUser]]} {
          set f [open [file join /usr apnscp var lock $lockUser] "r"]
          set lockData [read $f]
          close $f
          if {![string match $lockCookie $lockData]} {
            ::bgerror "Lock file contents do not match for user $lockUser! Expected: $lockData Got: $lockCookie"
            puts $sock "-1"
            catch {close $sock}
            return
          }
        } else {
            ::bgerror "Lock file does not exist for user $lockUser!"
            puts $sock "-1"
            catch {close $sock}
            return
       }
    }
   
    set host [lindex [split $data " "] 0]
    set type [lindex [split $data " "] 1]

    # :KLUDGE:
    # assume all numerics = user of a site, and not the admin
    # should make a cache for the user too in the near-future
    # very very nasty assumption.
    if {![regexp {^([0-9]+|[[:alpha:]]+)$} $host]} {
        if {$::LocalServer::debug} {
            puts "Checking Cache, data: [join $data]"
        }
        CheckCache $host
    }

    if {![info exists ::LocalServer::logFile]} {
        set ::LocalServer::logFile [open [file join $::LocalServer::logLocation localserver.log] {CREAT APPEND WRONLY}]
    }

    puts $::LocalServer::logFile "[clock format [clock seconds] -format "%c"] | $host | $addr | $port | [join $data |]"        
    close $::LocalServer::logFile
    unset ::LocalServer::logFile

    if {$::LocalServer::debug} {
        puts "Invoked: $type => $data"
    }
    
    switch "$type" {
        bwlog {
            set res [pg_exec $::LocalServer::connection "select bandwidth_spans.begindate, bandwidth_spans.enddate, sum(bandwidth_log.in_bytes) as in_bytes, sum(bandwidth_log.out_bytes) as out_bytes from bandwidth_spans CROSS JOIN  bandwidth_log  where bandwidth_log.site_id=[lindex $::LocalServer::cache($host) 7] AND bandwidth_log.ts >= bandwidth_spans.begindate::timestamp AND bandwidth_log.ts <= bandwidth_spans.enddate AND bandwidth_spans.site_id=[lindex $::LocalServer::cache($host) 7] GROUP by bandwidth_spans.enddate,bandwidth_spans.begindate ORDER by bandwidth_spans.begindate;"]
        set error [pg_result $res -error]
        if {![string equal "" $error]} {
            bgerror "Query Error: $error"
            puts $sock -1 ; catch {close $sock}
        } else {
            set bandwidth ""
            set ntups [pg_result $res -numTuples]
            for {set i 0} {$i < $ntups} {incr i} {
                lappend bandwidth [pg_result $res -getTuple $i]
            }
            pg_result $res -clear
            puts $sock [join $bandwidth |]
        }
            
        }
        services {
            puts $sock [::LocalServer::GetServices [lindex $data 0] [lindex $data 2]]
        }        
        filters {
            set action [lindex [split $data " "] 2]
            set filter [lindex [split $data " "] 3]
            # nasty cheat, quicker than sitelookup
            file stat "/home/virtual/$host/var/www/html" owner    
            if {[string equal $action "delete"]} {
                set fp [open "/home/virtual/$host/etc/mail/access"]
                set fptmp [open "/home/virtual/$host/etc/mail/accesstmp" "a" 644]
                while {[gets $fp line] > -1} {
                    if {[string match "$filter*" $line]} { continue }
                    puts $fptmp $line
                }
                close $fp
                close $fptmp
                file copy -force "/home/virtual/$host/etc/mail/accesstmp" "/home/virtual/$host/etc/mail/access"
                file delete -force "/home/virtual/$host/etc/mail/accesstmp"
                exec chown root:root "/home/virtual/$host/etc/mail/access"

                exec /usr/sbin/makemap hash /home/virtual/$host/etc/mail/access.db < /home/virtual/$host/etc/mail/access

                exec chmod 644 /home/virtual/$host/etc/mail/access.db

                exec chmod 644 /home/virtual/$host/etc/mail/access   

                exec chown root:root "/home/virtual/$host/etc/mail/access.db"
                puts $sock "1"
            } elseif {[string equal $action "add"]} {
                set fp [open "/home/virtual/$host/etc/mail/access" "r+"]
                set match 0 ; # used to check for dupes
                while {[gets $fp line] > -1} {
                    if {[string match "$filter *" $line]} { set match 1 }
                }
                if {!$match} {
                    puts $fp "$filter REJECT"
                }
                close $fp
                exec chown root:root "/home/virtual/$host/etc/mail/access"

                exec /usr/sbin/makemap hash /home/virtual/$host/etc/mail/access.db < /home/virtual/$host/etc/mail/access

                exec chmod 644 /home/virtual/$host/etc/mail/access.db

                exec chmod 644 /home/virtual/$host/etc/mail/access   

                exec chown root:root "/home/virtual/$host/etc/mail/access.db"
                puts $sock "1"
            }
        }

        pgpasswd {
            # security hole, need to send a key between
            # one another when updating the password
            set username [lindex [split $data " "] 2]
            set passwd [lindex [split $data " "] 3]
            if {![string equal -nocase "root" $username] && ![string equal -nocase "postgres" $username]} {
                set fp [open "| psql -U postgres -c \"alter user $username with password '$passwd';\" template1"]
                set res [read $fp]
                close $fp
                if {[string equal "ALTER USER" $res]} {
                    puts $sock "1"
                } else {
                    ::bgerror "Error while updating password: $res"
                    puts $sock "-1"
                }
            } else {
                ::bgerror "Alert! Attempted to modify priviledged user's password ($username), denied."
            }
        }        

        mime {
            set param [lindex [split $data " "] 2]
            if {[string equal $param "add"]} {
                set mimeType [lindex [split $data " "] 3]
                set extension [lindex [split $data " "] 4]
                # nasty cheat
                file stat "/home/virtual/$host/var/www/html" owner
                set fp [open "/home/virtual/$host/var/www/html/.htaccess" "a" 644]
                puts $fp "AddType $mimeType $extension"
                close $fp
                exec chown $owner(gid):$owner(gid) /home/virtual/$host/var/www/html/.htaccess
                puts $sock "1"
            } elseif {[string equal $param "remove"]} {
                set mimeExtension [lrange [split $data " "] 3 end]
                # nasty cheat
                file stat "/home/virtual/$host/var/www/html" owner             
                set fp [open "/home/virtual/$host/var/www/html/.htaccess" "r" 644]
                set tmpfp [open "/home/virtual/$host/var/www/html/.htaccesstmp" "a" 644]
                while {[gets $fp line] > -1} {
                    if {[string match "AddType * $mimeExtension" $line]} { continue }
                    puts $tmpfp $line
                }
                close $fp
                close $tmpfp
                file delete -force "/home/virtual/$host/var/www/html/.htaccess"
                file copy -force "/home/virtual/$host/var/www/html/.htaccesstmp" "/home/virtual/$host/var/www/html/.htaccess"
                exec chmod 644 /home/virtual/$host/var/www/html/.htaccess
                file delete -force "/home/virtual/$host/var/www/html/.htaccesstmp"
                exec chown $owner(gid):$owner(gid) /home/virtual/$host/var/www/html/.htaccess
                puts $sock "1"
            } else {
                puts $sock "-1"
            }
        }

        frontpage {
            set param [lindex [split $data " "] 2]
            if {$param} {
                set fp [open "| /usr/local/bin/EnableVirtOption $host frontpage" {RDONLY}]
                puts $sock [read $fp]
                close $fp
            } else {
                set fp [open "| /usr/local/bin/DisableVirtOption $host frontpage" {RDONLY}]
                puts $sock [read $fp]
                close $fp    
            }
        }

        quota {
            puts $sock [lindex $::LocalServer::cache($host) 6]
        }

        uquota {
            set quotafp [open "| /usr/sbin/repquota -ua | grep  #$host"]
            set quota [string trim [read $quotafp]]
            catch {close $quotafp} err
	    if {![string equal "$quota" ""]} {
                puts $sock "[lindex $quota 2] [lindex $quota 3]"
            } else {
                puts $sock "-1"
            }
        }

        bwusage {

            # return bandwidth usage

            puts $sock [lindex $::LocalServer::cache($host) 2]

        }

        bwstart {
            # return beginning date of rollover date
            puts $sock [lindex $::LocalServer::cache($host) 4]
        }

        bwrollover {
            # rollover date
            puts $sock [lindex $::LocalServer::cache($host) 5]
        }

        getemail {
            puts $sock [lindex $::LocalServer::cache($host) 1]
        }

        mysqlusage {
            if {![string equal -nocase $host "admin"]} { puts $sock "-1" }
            set databases [lrange [split $data " "] 2 end]
            set dbs ""
            set maxsize 0
            foreach db $databases {
                set size 0
                foreach f [glob -nocomplain [file join /var lib mysql $db *]] {
                    set size [expr {$size + [file size $f]}]
                }
                if {$size > $maxsize} {
                    set maxsize $size
                }
                lappend dbs $db $size            
            }
            puts $sock "$dbs $maxsize"
        }

        default {
            set auxData ""
            if {[llength $data] > 2} {
                set auxData [lrange $data 2 end]
            }
            
            if {$::LocalServer::dynamicCustom} {
                catch {namespace delete ::Custom}
                namespace eval ::Custom {}
                if {[file exists [file join /usr apnscp lib custom.tcl]]} {
                    if {[catch {source [file join /usr apnscp lib custom.tcl]} error]} {
                        ::bgerror "Error while loading custom.tcl: $error"
                        puts $sock -1
                        catch {close $sock}
                        return
                    }
                }            
            }
            
            if {[string equal [info commands ::Custom::[set type]] ""]} {
                catch {puts $sock -1}
                catch {close $sock}
                set ::errorInfo ""
                ::bgerror "Unknown custom command: $type"
                return
            } elseif {[catch {puts $sock "[::Custom::[set type] [set host] [set auxData]]"} error]} {
                catch {puts $sock "-1"}
                catch {close $sock}
                set ::errorInfo ""
                ::bgerror "Error while executing command: $type\nError proceeds: $error"
                return
            }
        }
    }
    catch {close $sock}
}


# check entry
proc ::LocalServer::CheckEntry {src} {
    set src [split $src "."]
    foreach check $::LocalServer::entry {
        if {[string equal $check "127.0.0.1"] && [string equal $check $src]} {
            return 1
        }
        set ok 1
        set i 0
        foreach numeric [split $check "."] {
            if {[expr {($numeric ^ [lindex $src $i]) && [lindex $src $i]}]} {
                set ok 0
            }
            incr i
        }
        if {$ok} {
            return 1
        }
    }
    return 0
}

proc ::LocalServer::CheckLicense {} {
    if {![file exists [file join /usr apnscp etc .license]]} {
        return 0
    }
    
    # do a daily check
    if {![info exists ::LocalServer::lastCheck] || [expr {[clock seconds] - 86400}] > $::LocalServer::lastCheck} {
        set fp [open [file join /usr apnscp etc .license] "r"]
        set buffer ""
        set doBuffer 0
        while {[gets $fp line] >= 0} {
            if {$doBuffer && ![string match "=*" $line]} {
                append buffer [string trim $line]
            }
            if {[string match "=*" $line]} {
                set doBuffer [expr {$doBuffer ^ 1}]
            }
        }
        close $fp
        if {[catch {set sock [socket "apisnetworks.com" 59965]}]} {
            return 1
        }   
        puts $sock "[set buffer]"
        flush $sock
        set ret [read $sock]
        if {$ret == 0} {
            file delete -force -- [file join /usr apnscp etc .license]
            catch {close $sock}
            return 0
        }
        catch {close $sock}
        set ::LocalServer::lastCheck [clock seconds]        
    }
    
    if {[set ::LocalServer::isValid] != 1} {
        return 0
    }
    return 1
}

# field entries
proc ::entry {ip} {
    lappend ::LocalServer::entry $ip
}

# basic initialization routine, invoked AFTER
# the source of ini
proc ::LocalServer::SetValues {} {
    # default initialization routines
    if {![info exists ::LocalServer::cacheLatency]} {
        set ::LocalServer::cacheLatency 600
    }
              
    if {![info exists ::LocalServer::debug]} {
        set ::LocalServer::debug 0
    }
    
    if {![info exists ::LocalServer::port]} {
        set ::LocalServer::port 50015
    }
    
    if {![info exists ::LocalServer::host]} {
        set ::LocalServer::host "127.0.0.1"
    }
    
    if {![info exists ::LocalServer::logLocation]} {
        set ::LocalServer::logLocation "/usr/apnscp/var/log"
    }

    if {![info exists ::LocalServer::seed]} {
        set ::LocalServer::seed "builtin"
    }
    
    if {![info exists ::LocalServer::entry]} {
        set ::LocalServer::entry "127.0.0.1"
    }
    
    if {![info exists ::LocalServer::adminEmail]} {
        set ::LocalServer::adminEmail "me@@mydomain.com"
    }
    
    if {![info exists ::LocalServer::notifyErrors]} {
        set ::LocalServer::notifyErrors "1"
    }
    
    if {![info exists ::LocalServer::sendmailPath]} {
        set ::LocalServer::sendmailPath "/usr/sbin/sendmail -t -i"
    }
    
    if {![info exists ::LocalServer::isValid]} {
        set ::LocalServer::isValid 1
    }
    
    if {![info exists ::LocalServer::extraSecurity]} {
        set ::LocalServer::extraSecurity 1
    }
    
    if {![info exists ::LocalServer::dynamicCustom]} {
        set ::LocalServer::dynamicCustom 0
    }
    
    set ::LocalServer::debug 0

}

# source ini
if {![catch {set fp [open [file join [file dirname [info script]] ".." "etc" apnscp.ini] "r"]}]} {
    while {[gets $fp line] >= 0} {
        if {[string match "*\;*" $line]} {
            continue
        } else {
            eval $line
        }
    }
    close $fp
}
# now invoke the default values
::LocalServer::SetValues

# safety first!
rename proc __apnscp_proc

__apnscp_proc proc {name args body} {

    if {![string equal [info commands $name] ""]} {

        ::bgerror "Error: unable to redefine proc $name"
        
    } else {
        namespace eval ::Custom [list __apnscp_proc $name $args $body]
    }

}

# purge rename.
rename rename ""

namespace eval ::Custom { }
# load after ini
if {!$::LocalServer::dynamicCustom} {
    if {[file exists [file join /usr apnscp lib custom.tcl]]} {
        if {[catch {source [file join /usr apnscp lib custom.tcl]} error]} {
            ::error "Error while loading custom.tcl: $error"
        }
    }
}

if {![file exists [file join /usr apnscp etc .license]]} {
    ::error "\nLicense file does not exist, please visit http://apnscp.com/ - cannot load lService"
    exit
}

::LocalServer::InstantiateServer

#
# Local variables:
# tab-width: 4
# c-basic-offset: 4
# End:
# vim600: sw=4 ts=4 fdm=marker
# vim<600: sw=4 ts=4
#
@


1.1.1.1
log
@
@
text
@@
