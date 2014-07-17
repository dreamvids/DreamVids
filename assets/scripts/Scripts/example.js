
/**
 * Scripts/example.js
 *
 * EXAMPLE SCRIPT
 */

var meteo = new Script({

	pages: ["default", "watch"], // Pages 

	// OU // pages: "all", // OU ne pas spécifier

	call: function() { // Fonction appelée lorsque la page peut être manipulée

		console.log("Il pleut!", "{example script}");

	}

});