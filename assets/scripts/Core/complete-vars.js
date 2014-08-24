
/**
 * Core/complete-vars.js
 *
 * Completer une chaine de caractère avec une variable objet
 */

function complete_vars(query, object, path) {

    add = path ? path + '.' : '';

    if (object instanceof Array) {

        for (var id = 0, length = object.length; id < length; id++) {

            query = object[id] instanceof Object ? query.complete(object[id], add + id) : query.replace('${' + add + id + '}', object[id]);

        }

    }

    else if (object instanceof Object) {

        for (var id in object) {

            query = object.hasOwnProperty(id) && object[id] instanceof Object ? query.complete(object[id], add + id) : query.replace('${' + add + id + '}', object[id]);

        }

    }

    return query;

}