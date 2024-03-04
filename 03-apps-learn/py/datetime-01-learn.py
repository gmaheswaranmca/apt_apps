from datetime import date, timedelta
from dateutil.relativedelta import relativedelta

now = date.today() #<class 'datetime.date'>
tomorrow = now + timedelta(days=1)
yesterday = now - timedelta(days=1)

print(f'today = {now}')#today
print(f'tomorrow = {tomorrow}')
print(f'yesterday = {yesterday}')

nowWeekDayNumber = now.weekday()
print(f'today.weekDayNumber = {nowWeekDayNumber}, day={now.day}') # 5 for Sat [6Sun 5Sat 4Fri 3Thu 2Wed 1Tue 0Mon]

startWeek = now - timedelta(days=nowWeekDayNumber)
endWeek = startWeek + timedelta(days=6)
startWeekDayNumber = startWeek.weekday()
endWeekDayNumber = endWeek.weekday()
print(f'startWeek = {startWeek}, week day = {startWeekDayNumber}')
print(f'endWeek = {endWeek}, week day = {endWeekDayNumber}')

startMonth = now - timedelta(days=now.day-1)
endMonth = startMonth + relativedelta(months=1) - timedelta(days=1)
print(f'startMonth={startMonth}, endMonth={endMonth}')

 