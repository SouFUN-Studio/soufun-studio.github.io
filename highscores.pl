#!/usr/bin/perl
# The SQL database needs to have a table called highscores
# that looks something like this:
#
#   CREATE TABLE highscores (
#     game varchar(255) NOT NULL,
#     player varchar(255) NOT NULL,
#     score integer NOT NULL
#   );
#
use strict;
use CGI;
use DBI;

# Read form data etc.
my $cgi = new CGI;

# The results from the high score script will be in plain text
print $cgi->header("text/plain");

my $game = $cgi->param('game');
my $playerName = $cgi->param('playerName');
my $score = $cgi->param('score');

exit 0 unless $game; # This parameter is required

# Connect to a database
my $dbh = DBI->connect( 'DBI:mysql:PlayersAccounts', 'roberto', 'M0d3sty090!' )
    || die "Could not connect to database: $DBI::errstr";

# Insert the player score if there are any
if( $playerName && $score) {
    $dbh->do( "insert into highscores (game, player, score) values(?,?,?)",
        undef, $game, $playerName, $score );
}

# Fetch the high scores
my $sth = $dbh->prepare(
    'SELECT player, score FROM highscores WHERE game=? ORDER BY score desc LIMIT 10' );
$sth->execute($game);
while (my $r = $sth->fetchrow_arrayref) {
    print join(':',@$r),"\n"
}
