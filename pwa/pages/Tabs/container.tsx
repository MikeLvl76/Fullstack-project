import React, { useState } from "react";
import TabBar from "./bar";

export default function TabsContainer({ tabs }: any) {
    const [activeTab, setActiveTab] = useState(0);
  
    return (
      <div>
        <TabBar
          tabs={tabs}
          activeTab={activeTab}
          setActiveTab={setActiveTab}
        />
        <div className="graphs-content">
          {tabs.map((tab: any, index: number) => (
            index === activeTab && tab
          ))}
        </div>
      </div>
    );
  }