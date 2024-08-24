#include <bits/stdc++.h>

using namespace std;

class Graph{
    int V;// total vertex
    vector<vector<int>>adjacentList;
    vector<bool>visited;
    public: Graph(int V)
    {
        this->V=V;
        adjacentList.resize(V);
        visited.resize(V,false);
    }

    void addEdge(int src, int des)
    {
        adjacentList[src].push_back(des);
        adjacentList[des].push_back(src);
    }

    void dispaly()
    {
        for(int i=0; i<V; i++)
        {
            cout<<"Vertex "<<i;
            for(int v: adjacentList[i])
            {
                cout<< "->"<<v;
            }
            cout<<endl;
        }
    }

    void DFS(int v)
    {
        visited[v] = true;
        cout<<v<<"->";

        for(int u: adjacentList[v])
        {
            if(visited[u] == false)
            {
                DFS(u);
            }
        }
    }
};
int main()
{
    Graph G(5);

    G.addEdge(0,1);
    G.addEdge(0,4);
    G.addEdge(1,2);
    G.addEdge(1,3);
    G.addEdge(1,4);
    G.addEdge(2,3);
    G.addEdge(3,4);

    G.dispaly();
    G.DFS(0);

    return 0;
}
