// requestAnimationFrame polyfill by Erik Möller
// http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] 
                                   || window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

var Space = function(snap, element, vangraph) {
    this.snap = snap;
    this.element = element;
    this.vangraph = vangraph;
    this.shapes = {};
    this.nodes = {};
    this.animationTime = false;
    this.animationRequestId = false;
}
Space.prototype.startAnimation = function() {

    var me = this;

    // ignore if animation is already running
    if (me.animationRequestId !== false) {
        return;
    }
    
    //if (me.fireEvent('beforeanimation', me) === false) {
    //    me.stopAnimation();
    //    return;
    //}
    
    // show that animation is allowed
    me.animationRequestId = true;

    function step() {
        
        if (this.animationRequestId === false) {
            return;
        }
        
        me.animationRequestId = window.requestAnimationFrame(step, me.element);
        this.animationTime = new Date().getTime();
        me.runAnimation();
        
    }
    
    step();
    
}
Space.prototype.stopAnimation = function() {

    if (this.animationRequestId !== false) {

        window.cancelAnimationFrame(this.animationRequestId);
        this.animationRequestId = false;
        
    }
    
};

Space.prototype.runAnimation = function() {

    var now = new Date().getTime();
    var dt = !!this.animationTime ? now - this.animationTime : 1;
    this.animationTime = now;

    var energy = this.vangraph.applyForces(dt/100);
    if (energy > 0.001 && energy < 0.04) {
        this.stopAnimation();
    }
    
    // retrieve graph data
    var map = {}, ids = [], xValues = [], yValues = [];
    this.vangraph.getPositions(map, ids, xValues, yValues);

    for (var i=0, maxI=ids.length; i<maxI; i++) {
        var id = ids[i];
        var x = Math.round(xValues[i]);
        var y = Math.round(yValues[i]);
        
        this.nodes[id].x = x;
        this.nodes[id].y = y;

        if (!this.shapes[id]) {
            var text = this.nodes[id].value !== null ? this.nodes[id].value : id;
            this.shapes[id] = this.snap.text(x, y, text);
        } else {
            this.shapes[id].attr({
                x: x,
                y: y
            });
        }
    }
    
    for (var id in this.nodes) {
        var origin = this.nodes[id];
        if (!origin.nodes) {
            continue;
        }
        for (var i=0, maxI=origin.nodes.length; i<maxI; i++) {
            var target = origin.nodes[i];
            var path = 'M'+origin.x+' '+origin.y+'L'+target.x+' '+target.y;
            
            if (!target.arrow) {
                target.arrow = this.snap.path(path);
                target.arrowTail = this.snap.circle(origin.x, origin.y, 5);
            } else {
                target.arrow.attr({
                    path: path
                });
                target.arrowTail.attr({
                    cx: origin.x,
                    cy: origin.y
                });
            }

            target.arrow.attr({
                stroke: '#000'
            });
        }
    }
    
}
Space.prototype.addNode = function(node) {
    var me = this;
    
    if (!me.nodes[node.id]) {
        me.nodes[node.id] = node;
        
        me.vangraph.insertBody({
            id: node.id
        });
    } else {
        if (!me.nodes[node.id].nodes) {
            me.nodes[node.id].nodes = node.nodes;
        }
    }

    if (node.nodes) {
        for (var i=0, maxI=node.nodes.length; i<maxI; i++) {
            if (!me.nodes[node.nodes[i].id]) {
                me.nodes[node.nodes[i].id] = node.nodes[i];
            }
        }
        for (var i=0, maxI=node.nodes.length; i<maxI; i++) {
            me.vangraph.insertBody({
                id: node.nodes[i].id
            });
        }
        for (var i=0, maxI=node.nodes.length; i<maxI; i++) {
            me.vangraph.insertSpring({
                id1: node.id,
                id2: node.nodes[i].id
            });
        }
    }

    me.startAnimation();
}

$(function() {
    var vangraph = new Vangraph({
        x: 10,
        y: 10,
        width: 800,
        height: 600
    });
    var snap = Snap('#svg');
    var space = new Space(snap, document.getElementById('svg'), vangraph);
    
    var nodeIds = window.location.hash.substr(1).split(',');
    for (var i=0, maxI=nodeIds.length; i<maxI; i++) {
        $.getJSON('/api/node/?id='+nodeIds[i], function(node) {
            space.addNode(node);
        });
    }


    
    
});