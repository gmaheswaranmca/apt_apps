import unittest
  
class TestAptJobDao_AddJobScore(unittest.TestCase):
  
    # Returns True or False. 
    def test(self):        
        self.assertTrue(True)

    # Returns True or False. 
    def testAddJobScoreTest1Test2(self):        
        from aptdb.aptjobdao import AptJobDao
        opStatus = AptJobDao.addScoreJob("Test1,Test2")
        self.assertTrue(opStatus)
    def testAddJobScoreTest1Test2Test3Eq(self):        
        from aptdb.aptjobdao import AptJobDao
        opStatus = AptJobDao.addScoreJob("Test1,Test2,Test3")
        self.assertEqual(opStatus, True)
if __name__ == '__main__':
    unittest.main()