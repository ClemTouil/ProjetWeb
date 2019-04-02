def inverse(L):
    return [L[1],L[0]]

print(inverse([1,2]))

def inverseG(L): #pour un quartier
    M = []
    for i in range(0,len(L)):
        M.append(inverse(L[i]))
    return M

def invList(L):
    M = []
    for i in range(0,len(L)):
        M.append(inverseG(L[i]))
    return M
    

print(inverseG([[7,1],[5,8]]))

#print(invList([[[1,2],[3,4]],[[5,6],[7,8]],[[9,10],[11,12]]]))

#print(invList([]))
