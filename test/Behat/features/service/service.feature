Feature: ZF2 service for workflow

  Scenario: Test zf2 service
    Given : Registrate the workflow with the name "example". With xml:
  """
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE workflow PUBLIC "-//OpenSymphony Group//DTD OSWorkflow 2.6//EN"
        "http://www.opensymphony.com/osworkflow/workflow_2_8.dtd">
<workflow>
    <registers>
        <register type="phpshell" variable-name="testVariable1">
            <arg name="script">return "test_value1";</arg>
        </register>
        <register type="phpshell" variable-name="testVariable2">
            <arg name="script">return "test_value2";</arg>
        </register>
    </registers>
    <initial-actions>
        <action id="100" name="StartWorkflow">
            <pre-functions>
                <function type="service">
                    <arg name="serviceName">callbackService</arg>
                    <arg name="serviceMethod">dispatch</arg>
                    <arg name="testArgName1">${testVariable1}</arg>
                    <arg name="testArgName2">${testVariable2}</arg>
                </function>
            </pre-functions>
            <results>
                <unconditional-result old-status="Finished" status="Underway" step="2"/>
            </results>
        </action>
    </initial-actions>
    <steps>
        <step id="2" name="First Draft">
            <actions>
                <action id="811" name="Finish_First_Draft">
                    <results>
                        <unconditional-result old-status="Finished" status="Underway"  step="2"/>
                    </results>
                </action>
            </actions>
        </step>
    </steps>
</workflow>
  """
    And Create workflow manager
    When Progress workflow with alias "test". Workflow name: "example". Initial action id: "100"
    Then Process of workflow with the alias "test" has the below steps:
      |stepId|
      |2     |
