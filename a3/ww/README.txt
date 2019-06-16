1. To setup the website server run:
    
    ./setup.sh

2. By default the setup will run the server but if there are any errors 
   with running ww_node.js in school server then:
   
    npm uninstall sqlite3 && npm install sqlite3 --build-from-source
    nodejs ww_node

   OR

    node ww_node

Extras:
    User:
	Admin system like piazza where users can become admins with the use of adminkeys
	Admins can delete users and admins, create new admin escalation keys, view all user info,
		and delete users
	Registration and update field validate their inputs and only whitelist specific inputs
	Users can upgrade to an admin account even after registration

    Game:
	Grazing enemies is +20 pts
	Killing enemies is +500 pts
    Special monster 1 follows the player using the astar algorithm
    Special monster 2 is random but becomes invisible for 5 seconds then visible for 20 seconds
