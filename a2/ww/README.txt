1. To setup the website server run:

    ./setup.sh

2. By default the setup will run the server but if there are any errors
   with running ww_node.js in school server then:

    npm uninstall sqlite3 && npm install sqlite3 --build-from-source
    nodejs ww_node

   OR

    node ww_node
