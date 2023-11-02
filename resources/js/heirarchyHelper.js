// Helper function to find a node by id
var findNodeById = function (roots, id) {
  for (const root of roots) {
    const queue = [root];
    while (queue.length > 0) {
      const node = queue.shift();
      if (node.id === id) {
        return node;
      }
      if (node.children) {
        queue.push(...node.children);
      }
    }
  }
  return null;
}

var buildHierarchyPath = function(roots, id) {
    let targetNode = findNodeById(roots, id);

    // If the node wasn't found in any of the roots, return null or an error message
    if (!targetNode) {
        return null; // or throw new Error('Node not found');
    }

    // Once we have the target node, we can build the path
    let path = [];
    let current = targetNode;

    while (current && current.parent_id !== undefined) {
        path.unshift(current.label); // Add the current node's label to the front of the path array
        // Find the parent node by searching through all roots
        current = findNodeById(roots, current.parent_id);
    }

    return path.join(' / ');
};

export {
    buildHierarchyPath
}
